# Library Management System

A web-based Library Management System developed as a university project using PHP, MySQL, HTML, CSS, JavaScript, and XAMPP.

## 📌 Project Overview

The Library Management System is designed to manage basic library operations through separate functionalities for administrators and students.

The system allows users to register, log in, search for books, request books, and manage library records.

## ✨ Features

### Admin Features

* Admin registration and login
* Add and manage books
* Add and manage students
* View and manage book requests
* Manage library records through the admin dashboard

### Student Features

* Student registration and login
* Student dashboard
* Search for available books
* Request books
* View book-related information

## 🛠️ Technologies Used

* **PHP** — Backend development
* **MySQL** — Database management
* **HTML** — Page structure
* **CSS** — Styling and layout
* **JavaScript** — Client-side functionality
* **XAMPP** — Local development environment
* **phpMyAdmin** — Database management

## 📂 Project Structure

```text
Library-Management-System/
│
├── database/
│   └── lms.sql
│
├── *.php
├── style.css
├── script.js
├── images/
└── README.md
```

## ⚙️ Requirements

Before running the project, install:

* XAMPP
* A web browser
* Git (optional, if cloning the repository)

## 🚀 Installation and Setup

### 1. Install XAMPP

Download and install XAMPP on your computer.

### 2. Copy the Project

Copy the project folder into the XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\LMS
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

* Apache
* MySQL

### 4. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a new database named:

```text
lms
```

### 5. Import the Database

Select the `lms` database in phpMyAdmin.

Go to:

**Import → Choose File**

Select:

```text
database/lms.sql
```

Then click **Import**.

### 6. Run the Project

Open your browser and visit:

```text
http://localhost/LMS
```

The Library Management System should now be running locally.

## 🗄️ Database Configuration

The project uses MySQL through XAMPP.

The default local database configuration is:

```text
Host: localhost
Username: root
Password: 
Database: lms
```

These settings are intended for the local XAMPP development environment.

## 🎓 Project Purpose

This project was developed as a university project to demonstrate the use of PHP, MySQL, HTML, CSS, and JavaScript in building a database-driven web application.

## 👨‍💻 Author

**Muhammad Taha Ahmad**

BS Computer Science
