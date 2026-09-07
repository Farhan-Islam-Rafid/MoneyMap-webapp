# MoneyMap v2.0

MoneyMap is a modern personal finance tracker built with PHP, MySQL/MariaDB, HTML, CSS, JavaScript, Bootstrap 5, Font Awesome, and Chart.js.

It helps users track income and expenses, understand monthly cash flow, review financial history, and monitor yearly savings.

## Features

- User registration and login
- Google sign-in with automatic account creation
- Session-based authentication
- Secure password hashing with `password_hash()` and `password_verify()`
- Dashboard with dynamic financial summaries
- Current balance calculation
- This month and previous month summaries
- Last 12 months overview
- Add, edit, and delete transactions
- Income and expense categorization
- Transaction search and filtering by type, year, month, and note
- Bangladeshi Taka formatting: `৳ 20,988.00`
- Yearly savings archive
- Profile and password updates
- Income versus expense chart
- Monthly balance chart
- Responsive desktop, tablet, and mobile layout
- PDO prepared statements
- CSRF protection on POST forms
- User-specific transaction and archive authorization

## Technology

- PHP 8+
- MySQL or MariaDB
- HTML5 and CSS3
- JavaScript
- Bootstrap 5
- Font Awesome
- Chart.js
- XAMPP-compatible

## Requirements

- XAMPP with Apache and MySQL/MariaDB
- PHP 8.0 or newer
- PHP `pdo_mysql` extension enabled
- PHP `curl` extension enabled
- A modern web browser

## Installation With XAMPP

1. Copy the project into the XAMPP web directory:

   ```text
   C:\xampp\htdocs\MoneyMap
   ```

2. Start **Apache** and **MySQL** from the XAMPP Control Panel.

3. Open phpMyAdmin at:

   ```text
   http://localhost/phpmyadmin
   ```

4. Import the database schema from:

   ```text
   database/moneymap.sql
   ```

   The SQL file creates the `moneymap` database and all required tables.

5. Check the database settings in:

   ```text
   config/database.php
   ```

   The default XAMPP settings are:

   ```php
   $dbHost = '127.0.0.1';
   $dbName = 'moneymap';
   $dbUser = 'root';
   $dbPass = '';
   ```

6. Open the application:

   ```text
   http://localhost/MoneyMap/
   ```

### Google sign-in setup

1. In Google Cloud Console, create an OAuth 2.0 Web application client.
2. Add `http://localhost/MoneyMap/google_callback.php` as an authorized redirect URI.
3. Set these environment variables for Apache/PHP. Do not put real credentials in `config/google.php`:

   ```text
   GOOGLE_CLIENT_ID=your-client-id
   GOOGLE_CLIENT_SECRET=your-client-secret
   GOOGLE_REDIRECT_URI=http://localhost/MoneyMap/google_callback.php
   ```

For XAMPP, add these lines to Apache's `conf/httpd.conf` and restart Apache:

```apache
SetEnv GOOGLE_CLIENT_ID "your-client-id"
SetEnv GOOGLE_CLIENT_SECRET "your-client-secret"
SetEnv GOOGLE_REDIRECT_URI "http://localhost/MoneyMap/google_callback.php"
```

4. For an existing database, run this once in phpMyAdmin:

   ```sql
   ALTER TABLE users MODIFY password VARCHAR(255) NULL;
   ALTER TABLE users ADD google_id VARCHAR(255) NULL UNIQUE;
   ```

Google accounts are matched by their verified email address, so an existing password account can be linked automatically on its first Google sign-in.

## Demo Account

A demo account is included in the local development database for presentation and testing:

```text
Email:    wow@gmail.com
Password: rafid2005
Username: wow_demo
```

The demo account contains approximately two years of varied financial transactions, including salary, freelance income, rent, food, transport, bills, internet, education, entertainment, medical, shopping, and family expenses.

For a public deployment, change or remove this account and use a secure password.

## Project Structure

```text
MoneyMap/
├── index.php                 Landing page
├── login.php                 Login form and authentication
├── register.php              Registration form
├── logout.php                Session logout
├── dashboard.php             Financial dashboard and transaction creation
├── transactions.php          Searchable transaction list
├── edit_transaction.php      Transaction editing
├── delete_transaction.php    Transaction deletion
├── archive.php               Yearly savings archive
├── profile.php               Profile and password management
│
├── config/
│   └── database.php          PDO database connection
│
├── includes/
│   ├── auth.php              Session authentication helpers
│   ├── functions.php         Shared formatting, validation, and calculation helpers
│   ├── header.php             Shared HTML header and navigation
│   └── footer.php             Shared footer and scripts
│
├── assets/
│   ├── css/
│   │   └── style.css         Responsive application styling
│   └── js/
│       ├── script.js         Shared browser interactions
│       └── charts.js          Chart.js rendering
│
└── database/
    └── moneymap.sql          Database schema
```

## Database Tables

### `users`

Stores account identity and hashed passwords.

### `transactions`

Stores user-owned income and expense records. Each record includes:

- Transaction type
- Amount
- Transaction date
- Optional note
- User ownership

### `yearly_archive`

Stores completed yearly totals for each user. A unique user/year constraint prevents duplicate archive rows.

## Main Routes

| Route | Purpose |
|---|---|
| `/` | Public landing page |
| `/register.php` | Create an account |
| `/login.php` | Log in |
| `/dashboard.php` | View summaries, charts, and recent transactions |
| `/transactions.php` | Search and filter transactions |
| `/edit_transaction.php?id=ID` | Edit an owned transaction |
| `/delete_transaction.php?id=ID` | Delete an owned transaction |
| `/archive.php` | View yearly savings records |
| `/profile.php` | Update profile details and password |
| `/logout.php` | End the current session |

## Financial Calculations

MoneyMap calculates all summary values from database records:

```text
Balance = Total Income - Total Expense
```

The dashboard calculates:

- All-time current balance
- Current calendar month totals
- Previous calendar month totals
- Rolling last 12-month totals
- Yearly archive totals for completed years

No financial summary values are hardcoded in the application.

## Security

The application includes basic security protections suitable for a local PHP project:

- PDO prepared statements
- Password hashing
- Session authentication
- Session ID regeneration after login
- CSRF tokens for important POST forms
- Ownership checks for transaction operations
- Escaped HTML output with `htmlspecialchars()`
- Server-side amount, date, and input validation
- Foreign keys with cascading user deletion

For production use, also configure HTTPS, environment-based database credentials, secure cookies, rate limiting, and a production database user with limited privileges.

## Development Notes

The project intentionally avoids heavy frameworks such as Laravel so it remains easy to understand and run in XAMPP. Shared logic is kept in `includes/`, while each page owns only the request handling needed for that page.

External frontend assets are loaded from CDN providers for Bootstrap, Font Awesome, Google Fonts, and Chart.js. An internet connection is needed for those assets unless they are downloaded and served locally.

## License

This project is intended for educational, demonstration, and personal use.
