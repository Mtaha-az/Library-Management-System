# Database ERD

This diagram documents the database structure used by the Library Management System.

```mermaid
erDiagram
    ADMINS {
        INT ID PK
        VARCHAR admin_email UK
        VARCHAR admin_name
        VARCHAR admin_password_reg
    }

    STUDENTS {
        VARCHAR studentID PK
        VARCHAR studentName
        VARCHAR studentEmail
        VARCHAR studentPassword
        VARCHAR degree
    }

    BOOKS {
        VARCHAR ISBN PK
        VARCHAR bookName
        VARCHAR authorName
        INT price
        INT quantity
    }

    REQUESTS {
        INT request_id PK
        VARCHAR student_id FK
        VARCHAR isbn FK
        VARCHAR book_name
        VARCHAR status
    }

    STUDENTS ||--o{ REQUESTS : submits
    BOOKS ||--o{ REQUESTS : requested_in
```

## Relationships

- One **student** can submit zero or many book requests.
- One **book** can appear in zero or many requests.
- Each **request** belongs to exactly one student and one book.
- **Admins** manage the application workflow but are not directly referenced by the current request records.

The `requests.student_id` and `requests.isbn` columns are enforced as foreign keys in the database schema.
