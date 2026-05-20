# biblioteka
Laravel Admin Panel za Biblioteku
Pokretanje


Email: admin@biblioteka.rs
Lozinka: admin123
Šta je implementirano
Migracije — 3 nove tabele: categories, books, borrowings

Modeli

Category.php — hasMany(Book)
Book.php — belongsTo(Category), hasMany(Borrowing), activeBorrowingsCount()
Borrowing.php — isReturned(), isOverdue(), overdueDays()
Middleware — AdminMiddleware.php štiti sve /admin/* rute, registrovan kao alias admin

Kontroleri

AuthController — login/logout
DashboardController — statistike
BookController — puni CRUD, pretraga, filter; blokira brisanje ako ima aktivnih pozajmica; validira da total_copies >= broju aktivnih pozajmica pri izmeni
BorrowingController — aktivne/sve/overdue, kreiranje, vraćanje (sa available_copies logikom)
CategoryController — CRUD, blokira brisanje ako postoje knjige
Rute — 20 admin ruta + login/logout, sve zaštićene middleware-om

Blade views — 15 stranica sa Bootstrap 5 (CDN), sidebar navigacija, flash poruke, paginacija

Seederi — 1 admin, 8 kategorija, 10 knjiga, 9 pozajmica (2 vraćene, 3 aktivne, 4 overdue)