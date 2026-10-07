# Library Management System

A database-driven Library Management System developed as a university project using PHP, MySQL, HTML, CSS, JavaScript, and XAMPP.

![Library Management System](lms.png)

## 📌 Project Overview

The Library Management System provides separate workflows for **administrators** and **students** to handle basic library operations.

The project demonstrates how a PHP web application can connect to a MySQL database and provide authentication, book management, student management, book searching, and book-request workflows.

## ✨ Features

### Admin Features

- Admin registration and login
- Add books
- Add students
- View and manage book requests
- Approve or decline book requests
- Admin dashboard

### Student Features

- Student login
- Student dashboard
- Search for books
- Submit book requests
- View book-related information

## 🛠️ Technologies Used

- **PHP** — Server-side application logic
- **MySQL** — Database management
- **HTML** — Page structure
- **CSS** — Styling and layout
- **JavaScript** — Client-side interactions and form handling
- **XAMPP** — Local Apache and MySQL development environment
- **phpMyAdmin** — Database administration

## 📂 Project Structure

```text
Library-Management-System/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
│
├── database/
│   └── lms.sql
│
├── addBook.php
├── addStudent.php
├── admin_service_dashboard.php
├── bookforrequest.php
├── data_class.php
├── db.php
├── index.php
├── loginadmin_server_page.php
├── logout.php
├── register.php
├── requestBook.php
├── requestsaction.php
├── searchBook.php
├── studentLogin_server_page.php
├── student_dashboard.php
│
├── E1.jpg
├── lib3.jpg
├── lms.png
├── lock.png
├── person.png
├── persons.jpg
├── unlock.png
├── .gitignore
└── README.md
```

The PHP files remain in the project root because they are directly used as the application's page and request endpoints. Frontend assets are separated into the `assets` directory, and the database export is kept in the `database` directory.

## ⚙️ Requirements

Before running the project, install:

- XAMPP
- A modern web browser
- Git (optional, if cloning the repository)

## 🚀 Installation and Setup

### 1. Clone or copy the project

Clone the repository into the XAMPP `htdocs` directory:

```bash
git clone https://github.com/Mtaha-az/Library-Management-System.git
```

Alternatively, copy the project folder manually into:

```text
C:\xampp\htdocs\LMS
```

### 2. Start XAMPP

Open the XAMPP Control Panel and start:

- Apache
- MySQL

### 3. Create the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
lms
```

### 4. Import the database

Select the `lms` database in phpMyAdmin.

Go to:

**Import → Choose File**

Select:

```text
database/lms.sql
```

Then click **Import**.

The SQL file creates the required tables and includes sample data for this academic project.

### 5. Check the database configuration

The project uses the following local XAMPP configuration:

```text
Host: localhost
Username: root
Password:
Database: lms
```

These settings are intended for a local XAMPP installation.

### 6. Run the project

Open your browser and visit:

```text
http://localhost/LMS
```

The Library Management System should now run locally.

## 🔑 Demo Accounts

The included database provides demo accounts for local testing.

**Admin**

```text
Email: demo@admin.library
Password: Demo123!
```

**Student**

```text
Student ID: demo001
Password: Demo123!
```

These credentials are only for the included academic/demo database.
## 🗄️ Database

The database contains tables for:

- Administrators
- Students
- Books
- Book requests

The database export is available at:

```text
database/lms.sql
```

## 🔐 Project Scope and Security

This repository contains a **university/academic project** and is not intended for production deployment.

The current version demonstrates the application's functionality and uses password hashing, prepared statements for major database operations, basic server-side validation, and output escaping. A production application would still require additional measures such as CSRF protection, stronger authorization controls, centralized secrets management, rate limiting, and more extensive testing.

The database contains generic demo records used for testing the project.

## 🎓 Project Purpose

This project was developed to demonstrate practical experience with:

- PHP server-side development
- MySQL database integration
- CRUD-style database operations
- Authentication and session handling
- Role-based application workflows
- HTML, CSS, and JavaScript
- Local web application development using XAMPP

## 👨‍💻 Author

**Muhammad Taha Ahmad**

BS Computer Science
