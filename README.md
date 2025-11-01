# 🎓 Fee Management System

A fully functional, web-based Fee Management System developed using PHP and MySQL. This system allows administrators to efficiently manage student records, track fee payments, and monitor pending dues in a user-friendly interface. It includes features for adding new students, updating details, managing payment history, and viewing summarized reports. Designed with a clean front-end and secure database integration, it simplifies fee management tasks for schools, coaching centers, and educational institutions.

---

## 🚀 Features
- Add, edit, and delete **student records**
- Record and manage **fee payments**
- View **pending payment reports**
- View **total collections and summaries**
- Secure **admin login and session management**
- Simple, clean, and responsive **user interface**

---

## 🧩 Pages Included
- `login.php` — Admin login page  
- `dashboard.php` — Admin dashboard showing key stats  
- `member.php` — Manage all student details  
- `payment.php` — Record and view payments  
- `pending.php` — View pending fee details  
- `database.php` — Database connection file  

---

## 🛠️ Technologies Used
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Server:** XAMPP / WAMP  

---

## ⚙️ Installation Steps

1. **Clone or download** this repository  
   ```bash\
2. Move the project folder to your XAMPP htdocs directory Example: C:\xampp\htdocs\fee-management-system
3. Start Apache and MySQL from the XAMPP Control Panel
4. Open phpMyAdmin and import the SQL file (e.g., fee_management.sql)
5. Open the database.php file and update it with your credentials: $conn = mysqli_connect("localhost", "root", "", "fee_management");
6. Run the project in your browser: http://localhost/fee-management-system/login.php
