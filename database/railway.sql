-- Library Management System database
-- Railway / hosted MySQL initialization for the LMS demo

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS requests;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE admins (
  ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
  admin_email VARCHAR(100) NOT NULL,
  admin_name VARCHAR(50) NOT NULL,
  admin_password_reg VARCHAR(255) NOT NULL,
  PRIMARY KEY (ID),
  UNIQUE KEY admin_email (admin_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE books (
  bookName VARCHAR(100) NOT NULL,
  authorName VARCHAR(100) NOT NULL,
  price INT NOT NULL,
  quantity INT NOT NULL,
  ISBN VARCHAR(20) NOT NULL,
  PRIMARY KEY (ISBN)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE students (
  studentID VARCHAR(20) NOT NULL,
  studentName VARCHAR(40) NOT NULL,
  studentEmail VARCHAR(100) NOT NULL,
  studentPassword VARCHAR(255) NOT NULL,
  degree VARCHAR(20) NOT NULL,
  PRIMARY KEY (studentID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE requests (
  request_id INT NOT NULL AUTO_INCREMENT,
  student_id VARCHAR(20) NOT NULL,
  isbn VARCHAR(20) NOT NULL,
  book_name VARCHAR(100) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (request_id),
  KEY idx_requests_student_id (student_id),
  KEY idx_requests_isbn (isbn),
  CONSTRAINT fk_requests_student
    FOREIGN KEY (student_id) REFERENCES students(studentID)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_requests_book
    FOREIGN KEY (isbn) REFERENCES books(ISBN)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample catalogue data. No default admin or student credentials are included.

INSERT INTO books (bookName, authorName, price, quantity, ISBN)
VALUES
('Introduction to Algorithms', 'Thomas H. Cormen', 2000, 5, '9780262033848'),
('Database System Concepts', 'Abraham Silberschatz', 1800, 4, '9780073523323'),
('Computer Networks', 'Andrew S. Tanenbaum', 2200, 3, '9780132126953');
