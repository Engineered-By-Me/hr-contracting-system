# ZeitKontrakt - Automated HR & Digital Contracting SaaS 🚀

A production-ready **Laravel 12** web application built to eliminate German bureaucratic friction in onboarding. It digitizes the entire employment journey from dynamic legal contract creation to cryptographically secure e-signatures and local file storage, following strict European architectural and data handling standards.

## 🛠️ Tech Stack & Architecture

- **Backend:** PHP 8.2+ & Laravel 12 (MVC Architecture, Clean & Decoupled Routing)
- **Frontend Interaction:** Livewire 3 (Asynchronous Form Processing & Reactive Validation)
- **Document Engine:** `laravel-dompdf` (Dynamic HTML-to-PDF legal document compiler)
- **Signature Core:** HTML5 Canvas API & JavaScript (Handwritten capture converted to Base64 data streams)
- **Storage Strategy:** Laravel Storage System (Decoupled safe local directories for CVs and legal contracts)
- **Security Operations:** Database Transactions (ACID compliance) and SHA-256 Signature Hashing for anti-tampering verification.

## ✨ Core Features

1. **Reactive HR Dashboard:** Seamless onboarding forms where HR managers enter candidate details, annual salary, and start dates with real-time feedback without page reloads.
2. **Automated CV Management:** Secure file upload mechanism restricted to authenticated PDF types with localized directory storage and dynamic server-side downloading naming conversions.
3. **Dynamic Legal Compiler:** Compiles dynamic employee variables directly into a fully-compliant German *Arbeitsvertrag* template, generating pristine localized PDFs.
4. **Interactive e-Signature Portal:** Dedicated candidate terminal rendering precise canvas signature capture using mouse or touch layouts.
5. **Anti-Tamper Cryptography:** Generates unique cryptographic sha256 tokens tying contract ID, timestamp, and metadata on execution. Re-compiles the document embedding strict digital audit metrics, locking the layout completely.

## 🔒 Architectural Highlights (Clean Code)
- Fully isolated Business Logic inside pure **Controllers**, leaving the `web.php` routing profile completely clean and expressive.
- Implements strict **Database Transactions** (`DB::transaction`) to enforce data integrity across complex dual-table multi-file pipelines.
- Configured local asynchronous logging mail systems (`MAIL_MAILER=log`) for robust high-performance processing.

## 🚀 How to Run Locally

1. Clone the repository: `git clone <your-repo-link>`
2. Install dependencies: `composer install`
3. Configure your `.env` file and link the database.
4. Run migrations: `php artisan migrate`
5. Create symbolic storage link: `php artisan storage:link`
6. Boot the local server: `php artisan serve`
