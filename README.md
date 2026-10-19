
# Event Booking System

A full-stack event booking application developed using **PHP, MySQL, HTML, CSS and JavaScript**, with a focus on secure web development, user authentication and database integration.

Developed as part of the MSc Computer Science with Artificial Intelligence at Northumbria University.

## App preview

<p align="center">
  <img src="preview01.gif" width="800">
</p>

## Key Features

- **User Authentication:** Account registration, login and logout with secure password hashing and verification.
- **Event Management:** Browse upcoming and past events, view event details and availability.
- **Booking System:** Reserve places at events, store booking information and review booking history.
- **Database Integration:** Relational MySQL database managing users, events and bookings.

## Security Implementation

Security was a central consideration in the development of the application.

- **SQL Injection Prevention:** MySQLi prepared statements and parameterized queries separate user inputs from SQL instructions.
- **Password Security:** PHP's `password_hash()` and `password_verify()` functions provide one-way password hashing and secure verification.
- **Session-Based Authentication:** PHP sessions maintain authenticated user state and enforce a 30-minute session timeout.
- **Cookie Management:** PHP session cookies associate browser requests with server-side authentication sessions, avoiding the storage of user credentials in cookies.
- **Input Validation:** Server-side validation of registration details, email addresses, passwords and booking quantities.
- **XSS Mitigation:** Use of `htmlspecialchars()` to escape HTML-sensitive characters in selected user inputs.
- **Access Control:** Session-based checks restrict account and booking functionality to authenticated users.

## Technology Stack

| Layer | Technologies |
|-------|-------------|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Database Access | MySQLi, Prepared Statements |
| Authentication | PHP Sessions, Password Hashing |

## Project Structure

- `content/functions/` — Core application logic, authentication, validation and database operations.
- `content/includes/` — Reusable PHP components and forms.
- `content/db/` — Database schema and sample data.
- `content/loginProcess.php` — User authentication.
- `content/registerValidation.php` — Registration validation.
- `content/bookingProcess.php` — Booking processing.
- `content/myAccount.php` — Account management and booking history.

## Project Status

Completed academic project demonstrating full-stack web development, relational database integration and foundational web application security practices.

**Status:** Archived — no active deployment.
