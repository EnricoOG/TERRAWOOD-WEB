<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## TERRAWOOD revision notes (November 2026)

- Public website language switch: English (default), Indonesian, and Simplified Chinese. The language selector is wired to a session route. Main interface labels are translated; names and descriptions entered for products, categories, services, articles, and portfolio items remain original database content.
- Hero slideshow automatic interval: 15 seconds.
- Product discounts: enter an optional discount price in the product create/edit form. The discount must be lower than the regular price; public product cards and details display the regular price crossed out and the discount price below.
- Product inquiry shortcuts: WhatsApp and email links are available on product detail pages; an email shortcut is also beside the floating WhatsApp button.
- Customer checkout orders are saved in the database and an email notification is attempted to the business email set in `config/terrawood.php`. To deliver email rather than write to the log, configure the SMTP variables in your local `.env` (do not share your credentials).

### Local test setup (Laragon / MySQL)

This archive includes the project's recovered local `.env` configuration so it does not fall back to the SQLite settings in `.env.example`. Keep the `.env` file private; do not upload or share this ZIP publicly.

1. Confirm MySQL is running in Laragon and the database named in `.env` exists.
2. Open the project folder in VS Code and run:

```bash
php artisan config:clear
php artisan migrate
php artisan serve
```

The additive migrations add a nullable `discount_price` column to `products`, optional `country` and `google_id` columns to `users`, and a `manual_sales` table. They do **not** delete or reset existing data. Do not run `php artisan migrate:fresh`.

If the local database name or credentials differ, adjust only the database values in `.env` to match your existing MySQL database. Do not replace `.env` with `.env.example` unless you have copied the required values first.

### Email configuration

Set these in your local `.env` using your email provider's SMTP details:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_SCHEME=tls
MAIL_FROM_ADDRESS=your-sender-address
MAIL_FROM_NAME="TERRAWOOD"
```

The notification destination is the `email` value in `config/terrawood.php` (currently `info@terrawood.id`). After changing config values, run `php artisan config:clear`.


### Additional revision (Google sign-in, customer email list, sales analytics)

Run `php artisan migrate` to add optional country/Google ID columns and the manual-sales table. Existing data is retained.

- Registration collects country; Google sign-in is available when OAuth credentials are configured.
- Configure `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` in `.env`; in Google Cloud Console set the authorized redirect URI to `http://localhost:8000/auth/google/callback` (adjust to your local domain).
- Admin customer list: `/admin/customers`.
- Sales analytics/manual input/export: `/admin/sales`. Export is CSV with UTF-8 BOM, compatible with Excel.
- Revenue totals include completed website orders and manually entered sales.

## Terrawood multilingual content (EN / ID / 简体中文)

- The existing language selector in the navbar is retained. English (`en`) is the default, Indonesian (`id`) and Simplified Chinese (`zh`) are available.
- A new additive migration adds a nullable JSON `translations` column to products, categories, services, articles, portfolios, and partners. Existing rows and columns are preserved.
- In the admin create/edit forms for those content types, open each language panel and enter the matching text. Leave a translation blank only when you intentionally want the original legacy field to be used as fallback.
- Public product, category, service, article, portfolio, and partner content reads the selected language from these saved translations. The homepage hero copy also has EN / ID / Chinese variants.

### Setup after receiving the ZIP

1. Keep your existing `.env` file. It is intentionally not included in this ZIP so that local database credentials and `APP_KEY` are not overwritten.
2. If this is a fresh setup, copy `.env.example` to `.env`, then configure the MySQL credentials and run `php artisan key:generate`.
3. Start MySQL in Laragon, then run `php artisan config:clear` and `php artisan migrate`.
4. Do not run `php artisan migrate:fresh`; the new translation migration is additive and does not delete existing content.
5. Run `php artisan serve` and test the language selector in the navbar.

Existing database content was not machine-translated. For the manual-entry workflow selected for Terrawood, an admin must fill in English and Chinese translations for existing records in the admin edit forms. Until then, the original content is shown as a safe fallback.
