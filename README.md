# Wallet-Service-API
📌 Overview

This project is a Wallet Service REST API built with PHP (Laravel).
It simulates a digital wallet system allowing users to create wallets, deposit and withdraw funds, transfer money between wallets, and retrieve balances and transaction histories.

🛠 Tech Stack

PHP 8.2+

Laravel 11

MySQL

RESTful API

Postman (for API testing)

🧱 Architecture & Design

The project follows Clean Code principles and separates responsibilities clearly:

Controllers: Handle HTTP requests & responses only

Services: Contain business logic

Repositories: Data access layer

Enums: Transaction types, currencies

Database Transactions: Ensure atomicity

Idempotency Service: Prevent duplicate operations

Design patterns used:

Service Layer Pattern

Repository Pattern

Enum Pattern

Transaction Script (for money operations)

📂 Project Structure
app/
 ├── Http/Controllers/
 ├── Services/
 │    ├── WalletService.php
 │    ├── TransactionService.php
 │    └── IdempotencyService.php
 ├── Repositories/
 ├── Enums/
 └── Models/

🧪 API Endpoints
Health
GET /api/health

Wallets
POST   /api/wallets
GET    /api/wallets
GET    /api/wallets/{id}
GET    /api/wallets/{id}/balance

Deposits & Withdrawals
POST /api/wallets/{id}/deposit
POST /api/wallets/{id}/withdraw


Requires Idempotency-Key header

Transfers
POST /api/transfers


Requires Idempotency-Key header

Transactions History
GET /api/wallets/{id}/transactions


Filters:

type

date_from

date_to

pagination

💰 Monetary Rules

All amounts are stored as integers (minor units)

No floating point operations

No negative balances allowed

🔒 Idempotency

All write operations support idempotency

The same Idempotency-Key will never duplicate transactions

Stored responses are returned on repeated requests

⚙️ Setup Instructions
git clone https://github.com/your-username/wallet-service-api.git
cd wallet-service-api
composer install
cp .env.example .env
php artisan key: generate
php artisan migrate
php artisan serve

📮 Postman Collection

A complete Postman collection is included to test all endpoints and scenarios:

Deposits

Withdrawals

Transfers

Idempotency behavior

🚀 Possible Improvements

Add authentication & authorization

Add database indexing for high-volume transactions

Wallet locking for extreme concurrency

Caching balances

👨‍💻 Author

Azmy Kamel
PHP Backend Developer
