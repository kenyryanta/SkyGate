document.getElementById("pay-button").onclick = function () {
    snap.pay("{{ $snapToken }}", {
        onSuccess: function (result) {
            alert("Payment successful! Updating status...");

            // Panggil Webhook secara manual
            fetch('{{ route("transactions.notification") }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    order_id: "{{ $transaction->code }}",
                    transaction_status: "settlement",
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Webhook response:", data);
                    if (data.status === "success") {
                        alert("Payment updated! Redirecting...");
                        window.location.href =
                            '{{ route("transactions.show", $transaction->id) }}';
                    } else {
                        alert("Failed to update payment status.");
                    }
                })
                .catch((error) => {
                    console.error("Error calling webhook:", error);
                    alert("Error updating payment status.");
                });
        },

        onPending: function (result) {
            alert("Payment is pending. Please complete your payment.");
            console.log(result);
        },

        onError: function (result) {
            alert("Payment failed. Please try again.");
            console.log(result);
        },

        onClose: function () {
            alert(
                "You closed the payment window without completing the payment."
            );
        },
    });
};
