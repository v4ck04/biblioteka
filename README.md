# Biblioteka — Library Management System

A library management system built during an internship. The project covers an **Admin Panel**, a **public-facing frontend**, a **book catalog**, a **borrowing system**, and **user request forms**.

---

# About the Project

"Biblioteka" is a web application designed to simplify the management of a library system.

The application supports:

* administration of books and categories
* borrowing management
* tracking of active and overdue loans
* book search
* catalog browsing
* borrowing requests
* a public frontend view of the library for end users

---

# Tech Stack

The project was built using:

* **Laravel**
* **PHP**
* **MySQL**
* **Blade Templates**
* **Bootstrap 5**
* **Visual Studio Code**
* **WAMP Server**
* **Claude AI** (research, planning, and development assistance)

---

# Features

## Admin Panel

### Dashboard

Displays system-wide statistics:

* total number of books
* number of categories
* active loans
* overdue loans
* quick access to admin modules

### Books

Module for managing the library's collection.

Features:

* list all books
* add a book
* edit a book
* delete a book
* search
* filter by category
* copy count control

### Categories

CRUD functionality:

* add categories
* edit categories
* delete categories
* protection against deletion when a category has books linked to it

### Borrowings

Loan management system:

* active loans
* overdue loans
* borrowing history
* create a new loan
* process returns
* available-copies logic

### Readers and Requests

* reader management
* processing of user requests

---

## Frontend Site

The user-facing side of the application makes it easy to find and browse books.

### Search

Supported search options:

* by title
* by author
* by genre

### New Arrivals

Displays recently added books.

### More From This Category

Suggests similar books from the same category.

### Catalog

The complete library catalog with a structured data view.

---

## User Forms

### Request a Loan

A form that lets a user submit a request to borrow a book.

Includes:

* field validation
* input correctness checks
* database integration

---

# Database

The project uses a **MySQL** database.

---

## Tables

### categories

Stores book categories.

### books

Stores book records.

### borrowings

Stores loan records.

---

# Laravel Implementation

## Models

### Category.php

* hasMany(Book)

### Book.php

* belongsTo(Category)
* hasMany(Borrowing)
* activeBorrowingsCount()

### Borrowing.php

* isReturned()
* isOverdue()
* overdueDays()

---

## Middleware

### AdminMiddleware.php

Protects all **/admin/** routes.

---

## Controllers

### AuthController

* login
* logout

### DashboardController

* system statistics

### BookController

* CRUD
* search
* filters
* validation
* blocks deletion of books with active loans

### BorrowingController

* active loans
* overdue loans
* history
* new loan
* returns

### CategoryController

* CRUD
* category deletion protection

---

# Seeder Data

The project ships with initial data:

* 1 admin user
* 8 categories
* 10 books
* 9 loans

  * 2 returned
  * 3 active
  * 4 overdue

---

# Getting Started

## 1. Clone the repository

```bash
git clone https://github.com/USERNAME/REPOSITORY.git
```

```bash
cd biblioteka
```

---

## 2. Install dependencies

```bash
composer install
```

---

## 3. Create the .env file

```bash
copy .env.example .env
```

Or copy `.env.example` manually.

---

## 4. Generate the application key

```bash
php artisan key:generate
```

---

## 5. Configure the database

Start **WAMP Server**.

Create the database:

```sql
biblioteka
```

Configure `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteka
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Import the database

### Option 1 — SQL import

Import:

```txt
biblioteka.sql
```

via phpMyAdmin.

### Option 2 — Laravel migrations

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

---

## 7. Run the project

```bash
php artisan serve
```

Open:

```txt
http://127.0.0.1:8000
```

---

# Admin Login

Email:

```txt
admin@biblioteka.rs
```

Password:

```txt
admin123
```

---

# Authors

Built during the **W3 LAB internship**.

Team:

* Admin Panel and core functionality: Vladica Rizić
* Frontend development: Mihajlo Stojanović
* Redesign and user forms: Darko Stević
