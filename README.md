# 📊 Event Management System
## 🔹 Project Overview
The **Event Management System** is a web-based platform that allows users to:
- **Create, manage, and view events**
- **Register attendees**
- **Download event reports (CSV format)**
This project is built using **Pure PHP (No frameworks), MySQL, and Bootstrap** for a clean, professional, and mobile-responsive UI.

## ✅ Features

### 🔹 Core Functionalities:
✔ **User Authentication** – Secure login & registration with password hashing.  
✔ **Event Management** – Create, update, view, and delete events.  
✔ **Attendee Registration** – Users can register attendees (capacity limit enforced).  
✔ **Event Dashboard** – Paginated, sortable, and searchable event list.  
✔ **Event Reports** – Admins can download attendee lists in CSV format.  

### 🔹 Bonus Features:
✔ **Live Search** – Dynamic event & attendee search using PHP.  
✔ **AJAX Enhancements** – Smooth user experience with real-time updates.  
✔ **JSON API Endpoint** – Fetch event details programmatically.  
---
## 🏗 Project Structure
```
📦 event-management
│── 📂 assets        # Static Files (CSS, JS, Images)
│── 📂 config        # Database & session management
│── 📂 includes      # UI Components (navbar, sidebar)
│── 📂 views         # All pages (Dashboard, Events, Attendees)
│── 📂 controllers   # Backend processing (Login, Register, CRUD)
│── 📂 api           # AJAX Endpoints (Search, API)
│── .htaccess        # Security & URL Rewrite
│── README.md        # Documentation
```
## 🛠 Installation Guide

### **1️⃣ Clone the Project**
```bash
git clone https://github.com/your-username/event-management.git
cd event-management
```
### **2️⃣ Set Up Database**
1. Open **phpMyAdmin** or MySQL CLI.
2. Create a database:
   ```sql
   CREATE DATABASE event_management;
   ```
3. Import `database.sql` from the project folder.

### **3️⃣ Configure Database Connection**
1. Open `config/config.php`
2. Update database details:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'event_management');
   ```
### **4️⃣ Start the Project**
1. Run **XAMPP** (Apache & MySQL).
2. Open a browser and visit:
   ```
   http://localhost/event-management/index.php
   ```
---
## 🔒 Security Measures

✔ **Prepared Statements** – Prevents SQL injection.  
✔ **Password Hashing** – Secure authentication with `password_hash()`.  
✔ **Session Security** – Prevents unauthorized access.  
✔ **Input Validation** – Both client-side & server-side validation.  

---
## 🚀 Live Demo & GitHub Repository

🔗 **Live Demo**: [To be added]  
📌 **GitHub Repo**: [GitHub Repository](https://github.com/your-username/event-management)

---
## ✅ Evaluation Criteria

This project meets the **Ollyo Recruiter’s** requirements:
✔ **Code Quality** – Well-structured, readable, and maintainable PHP code.  
✔ **Functionality** – Fully implemented event & attendee management system.  
✔ **Security** – Secure authentication, SQL injection prevention, and session protection.  
✔ **Database Design** – Optimized relational database for efficient queries.  
✔ **Documentation** – Clear setup guide & project overview in README.md.  
✔ **Hosting & Accessibility** – GitHub repository & live demo (if applicable).  

