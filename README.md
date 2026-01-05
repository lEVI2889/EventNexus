# EventNexus - Indoor Event Management System

EventNexus is a web-based platform designed to streamline the organization and booking of indoor events. It features role-based access for Admins, Hosts, and Customers.

## 🚀 Key Features
- **Host Dashboard:** Propose events with automated collision detection (checks venue availability and timing).
- **Admin Panel:** Approve/Reject event proposals and manage venue master data.
- **Customer Portal:** Browse approved events and book tickets.
- **Automated Ticketing:** Generates professional PDF tickets using the `dompdf` library.
- **Secure Payments:** Integrated venue booking system for Hosts to secure locations.

## 🛠️ Tech Stack
- **Backend:** PHP (Loosely typed, server-side logic)
- **Database:** MySQL (Relational database with normalized tables)
- **Frontend:** HTML5, CSS3 (Modern Glassmorphism UI)
- **Library:** dompdf (HTML to PDF conversion)
- **Version Control:** Git & GitHub

## 🔒 Security Implementations
- **SQL Injection Prevention:** Used `mysqli_real_escape_string` for all user inputs.
- **Access Control:** Role-based session verification (`Admin` vs `Host` vs `Customer`).
- **Input Validation:** Server-side and client-side format checks (Email, Date constraints).

---
*Developed as a Database Systems project by Shafiul Alam.*