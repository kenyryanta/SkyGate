<h1 align="center">✈️ SkyGate</h1>
<p align="center">
  <i>Online Flight Ticket Booking Web App</i><br>
  Built with <b>Laravel 11</b>, <b>Laravel Filament</b>, and <b>Midtrans Payment Gateway</b><br>
  <b>Developed by: M.Kenny Ryanta & Andika Rizky Putrahutama</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red" />
  <img src="https://img.shields.io/badge/Midtrans-Integrated-green" />
  <img src="https://img.shields.io/badge/Admin-Filament-blue" />
</p>

---

## 📌 Overview

**SkyGate** is a modern and user-friendly web application designed to simplify the process of booking airline tickets online. From searching for flights to secure payment processing, SkyGate offers a seamless and efficient experience for travelers.

This application is powered by **Laravel 11** as the backend framework, ensuring high performance, security, and maintainability. The admin panel is built using **Laravel Filament**, making flight, transaction, and user management intuitive and powerful. For payment processing, SkyGate integrates the **Midtrans** payment gateway to support secure, real-time transactions.

Whether you're a traveler or an administrator, SkyGate delivers a complete ecosystem for managing airline ticketing efficiently.

---

## 🚀 Key Features

### ✈️ For Users

-   🔍 **Search Flights** – Browse flights by date, origin, and destination
-   🧾 **Book Tickets** – Fill in passenger data and reserve your seat
-   💳 **Pay Securely** – Integrated Midtrans payment gateway
-   📄 **Download E-Ticket** – Get ticket receipt directly after purchase
-   🌐 **Responsive UI** – Optimized for desktop and mobile experience

---

### 🔐 Login Page

![Login Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Login.png)  
Users can securely log in to their account. The design is simple and easy to use, ensuring a quick entry to the platform.

---

### 📝 Register Page

![Register Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Register.png)  
This page allows new users to sign up for an account. The registration form includes input fields for personal details, ensuring proper validation.

---

### 🏠 Home Page

![Home Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Home.png)  
The landing page where users can start searching for flights and view offers. The layout is optimized for easy navigation and fast access to all functionalities.

---

### 🔍 Flight Search & Filter

![Flight Search](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/flight.jpg)  
Users can search for flights by specifying **origin, destination, and date**. Filtering options include choosing specific airlines, price range, and flight class (Economy or Business).

---

### 🧾 Booking Page (Step 1 & Step 2)

#### ✈️ Step 1: Select Flight Class & Passengers

![Booking Step 1](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Bookings.png) 
Users can select the **flight class** (Economy, Business or First), specify the **number of passengers**, and view facilities available in the selected class. This helps them make an informed choice based on their preferences and needs.

---

#### 👤 Step 2: Passenger Details, Seat Selection & Promo

![Booking Step 2](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Bookings%20Detail.png)  
In this step, users input **personal information** for each passenger, choose their **seats** on the plane, and apply available **promo codes**. The layout ensures clarity and ease during the final confirmation process.

---

### 💳 Payment Page

![Payment Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Payment.png)  
![Payment Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Payment%20Midtrans.png)  
The payment page integrates the  **Midtrans** service, allowing users to make secure payments via multiple methods such as credit cards, e-wallets, and bank transfers.

---

### 📄 Transaction History & E-Ticket

![Transaction Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Transaction%20History.png)  
After payment is confirmed, users can view their booking details and download the **e-ticket** in PDF format. Transaction history is also available for reference.

---

### 👨‍💼 For Admins

-   🛫 **Manage Flights & Routes**
-   💰 **Monitor Transactions & Payments**
-   👤 **User Management**
-   📊 **Booking Dashboard & Metrics**
-   ⚙️ **Admin Panel via Laravel Filament**

---

### 🔐 Admin Login Page  
![Admin Login Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Login%20admin.png)  
Admins securely access the backend using this dedicated login page. It ensures that only authorized personnel can manage flights, airlines, facilities, and customer data within the system.

---

### 📊 Dashboard

![Dashboard Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Dashboard%20admin.png)  
Displays a summary of important metrics such as number of customers, total flights, revenue, and recent activities. A quick overview for monitoring system status.

---

### ✈️ Airlines Management

![Airlines Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Airlines%20admin.png)  
Admins can add, update, or delete airline data. This includes setting airline names, codes, and logos.

---

### 🛫 Airports Management

![Airports Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Airports%20admin.png)  
Used to manage airport data such as airport names, locations, and codes for both origin and destination purposes.

---

### 🛫 Flights Management

![Flights Page](https://github.com/AndikaRzk/SkyGate/blob/main/public/images/Flights%20admin.png)  
Central page for adding and managing flight schedules, including departure/arrival info, airline, class, and prices.

---

### 👥 Customers Data

Displays the list of registered users/customers. Admins can view customer profiles and monitor user activity.

---

### 🏢 Facilities Management

Manages general flight facilities such as Wi-Fi, meals, or entertainment options, which can be later assigned to flight classes.

---

### 🧷 Flight Class Facilities

Allows mapping of facilities to specific flight classes (e.g., Economy, Business) to ensure accurate service offerings.

---

### 💺 Flight Classes

Admins can define flight classes like Economy, Business, or First Class and set descriptions and price modifiers.

---

### 🧾 Flight Seats

Manages seat layouts per flight, allows assigning seats to specific flights and updating their availability status.

---

## 🛠️ Tech Stack

| Layer           | Technology       |
| --------------- | ---------------- |
| Backend         | Laravel 11       |
| Admin Panel     | Laravel Filament |
| Payment Gateway | Midtrans         |
| Frontend        | Bootstrap 5      |
| Database        | MySQL            |
| Dev Tools       | Composer, NPM    |

---

## ⚙️ Installation Guide
```
bash

1. Clone the repository

git clone https://github.com/AndikaRzk/SkyGate.git
cd skygate

2. Install PHP and JavaScript dependencies

composer install
npm install && npm run dev

3. Create and configure environment file

cp .env.example .env
php artisan key:generate

4. Run database migrations and seed data

php artisan migrate --seed

5. Create symbolic link for storage (if your app uses file uploads or displays images)

php artisan storage:link

6. Start the local development server

php artisan serve
```
---

## 👨‍💻 Developers

This project is proudly developed by:

### **Collaborative Development & Design**

-   👨‍💻 **M.Kenny Ryanta & Andika Rizky Putrahutama**
    Both developers worked collaboratively across multiple areas of the project, including:

    -   **Backend Development** – API development, database design, server-side logic
    -   **Frontend & Admin Panel** – Admin panel development using **Laravel Filament**, UI/UX design, responsive layouts
    -   **Payment Gateway Integration** – Secure payment integration with **Midtrans**
    -   **User Experience Optimization** – Streamlining the flow from ticket search to booking and payment

    [GitHub: M.Kenny Ryanta](https://github.com/kenyryanta) | [GitHub: Andika Rizky Putrahutama](https://github.com/AndikaRzk)

---
