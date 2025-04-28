<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{

    public function index()
    {
        // Pastikan hanya pelanggan yang sedang login bisa melihat transaksi mereka
        $customer = Auth::guard('customers')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your transactions.');
        }

        // Ambil transaksi berdasarkan customer_id
        $transactions = Transaction::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('transactions.index', compact('transactions'));
    }




    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$appendNotifUrl = route('transactions.notification');
    }

    /**
     * Menampilkan halaman pembayaran menggunakan Snap Midtrans.
     */
    public function showPayment(Transaction $transaction)
    {
        // Check if payment is already completed
        if ($transaction->payment_status === 'paid') {
            return redirect()->route('transactions.show', $transaction->id)
                ->with('info', 'This transaction has already been paid.');
        }

        // Load necessary relationships
        $transaction->load(['flight.airline', 'flightClass']);

        // Validate required data
        if (!$transaction->flight || !$transaction->flightClass) {
            return redirect()->back()->with('error', 'Invalid transaction data.');
        }

        // Create transaction parameters for Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => (int) $transaction->grandtotal,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
            'item_details' => [
                [
                    'id' => $transaction->flightClass->id,
                    'price' =>(int) $transaction->grandtotal,
                    'quantity' => 1,
                    'name' => "Flight {$transaction->flight->flight_number} - {$transaction->flightClass->class_type}",
                ]
            ],
        ];

        try {
            // Get Snap Payment Page URL
            $snapToken = Snap::getSnapToken($params);

            // Logging Snap token for debugging purposes
            Log::info('Midtrans Snap Token generated:', ['snap_token' => $snapToken]);

            return view('transactions.payment', compact('transaction', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Error generating Snap token:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', "Error generating payment: {$e->getMessage()}");
        }
    }

    /**
     * Menangani notifikasi dari Midtrans (Webhook).
     */
   /**
 * Menangani notifikasi dari Midtrans (Webhook).
 */

 /**
 * Menampilkan detail transaksi
 */
public function show(Transaction $transaction)
{
    // Load relasi yang diperlukan
    $transaction->load(['flight.airline', 'flightClass']);

    return view('transactions.show', compact('transaction'));
}

public function handleNotification(Request $request)
{
    try {
        // Decode JSON dari request Midtrans
        $notificationBody = json_decode($request->getContent(), true);
        Log::info('📩 Midtrans Notification Received:', ['notification_body' => $notificationBody]);

        // Validasi field yang wajib ada
        if (!isset($notificationBody['order_id'], $notificationBody['transaction_status'])) {
            Log::error('❌ Invalid notification data: Missing required fields');
            return response()->json(['status' => 'error', 'message' => 'Invalid notification data'], 400);
        }

        // Ambil kode transaksi dari Midtrans
        $orderId = $notificationBody['order_id'];
        $status = $notificationBody['transaction_status'];

        // **🔍 Cek apakah transaksi ada di database**
        $transaction = Transaction::where('code', $orderId)->first();

        if (!$transaction) {
            Log::error('❌ Transaction not found in database:', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        Log::info('✅ Transaction found:', [
            'id' => $transaction->id,
            'code' => $transaction->code,
            'current_status' => $transaction->payment_status
        ]);

        // **🔍 Cek ulang status transaksi langsung dari Midtrans API**
        $serverKey = config('midtrans.server_key');
        $midtransResponse = Http::withBasicAuth($serverKey, '')
            ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status")
            ->json();

        Log::info('📡 Midtrans API Response:', ['midtransResponse' => $midtransResponse]);

        if (!isset($midtransResponse['transaction_status'])) {
            Log::error('❌ Failed to retrieve transaction status from Midtrans');
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve transaction status'], 500);
        }

        // **Gunakan data terbaru dari Midtrans API**
        $status = $midtransResponse['transaction_status'];

        // **🗂 Mapping status Midtrans ke database `payment_status`**
        $statusMapping = [
            'settlement' => 'paid',
            'capture' => 'paid',
            'pending' => 'pending',
            'deny' => 'canceled',
            'cancel' => 'canceled',
            'expire' => 'canceled'
        ];

        $newStatus = $statusMapping[$status] ?? 'canceled';

        // **⏫ Update hanya jika `payment_status` berubah**
        if ($transaction->payment_status !== $newStatus) {
            $transaction->update(['payment_status' => $newStatus]);

            Log::info('✅ Transaction status updated:', [
                'order_id' => $orderId,
                'old_status' => $transaction->payment_status,
                'new_status' => $newStatus
            ]);
        } else {
            Log::info('ℹ️ No changes in transaction status:', [
                'order_id' => $orderId,
                'status' => $newStatus
            ]);
        }

        return response()->json(['status' => 'success']);

    } catch (\Exception $e) {
        Log::error('❌ Error handling Midtrans notification:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
    }
}

    public function download($id)
    {
        $ticketPath = "public/tickets/eticket_$id.pdf"; // Path asli dalam storage Laravel

        if (Storage::exists($ticketPath)) {
            // Format nama file dengan tanggal & waktu saat ini
            $timestamp = now()->format('Y-m-d_H-i-s');
            $newFileName = "eticket_{$id}_{$timestamp}.pdf";

            return Storage::download($ticketPath, $newFileName);
        }

        return back()->with('error', 'Ticket not found.');
    }
}
