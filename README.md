# The Body Fragrances Backend

This repository contains the PHP backend and admin panel for The Body Fragrances project.

## What this project includes

- Admin dashboard for managing categories, products, news/offers, and orders
- PHP API services used by the mobile app
- Image upload folders for categories, products, and news

## Main entry points

- `dashboard.php` - admin home page
- `login.php` / `login.html` - admin authentication
- `services/` - API endpoints for the mobile app
- `db.php` - database connection configuration

## Local setup

1. Put the project inside your XAMPP `htdocs` folder.
2. Start Apache and MySQL from XAMPP.
3. Create a database named `thebodyfragrances`.
4. Update `db.php` if your database username, password, or host is different.
5. Open `http://localhost/thebodyfragrances/` in your browser.

## Notes

- Keep `db.php` aligned with your local or live database settings.
- The Android app should point to the live URL of the `services/` endpoints.
- Uploaded images are stored under `uploads/`.

## GitHub

Repo: https://github.com/Muhammad-Hassan216/thebodyfragrances-backend