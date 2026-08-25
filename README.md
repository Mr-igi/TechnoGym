# TechnoGym

A gym membership and training-booking website built with Laravel 13.

Members can browse trainers, book one-on-one training sessions, sign up for recurring
group classes, and purchase a monthly membership. An admin panel manages trainers,
membership plans, group classes, users, and booking requests.

> **Note:** the user interface is in Serbian. This README is in English so the setup
> steps are readable to anyone; the code, routes, and database columns are also in
> English, and only the on-screen text is localized.

---

## Tech stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.3+ |
| Templating | Blade |
| Styling | Bootstrap 5.3 + custom CSS variables (dark theme) |
| Build tool | Vite 8 |
| Database | SQLite by default, MySQL/MariaDB optional |
| Icons | Bootstrap Icons |

---

## Requirements

Before you start, make sure you have:

- **PHP 8.3 or newer** with the `pdo_sqlite` extension enabled
  (or `pdo_mysql` if you prefer MySQL)
- **Composer 2**
- **Node.js 20 or newer** and npm

Check your versions:

```bash
php -v
composer -V
node -v
```

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/<your-username>/<your-repo>.git
cd <your-repo>

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create your environment file
cp .env.example .env          # on Windows PowerShell: copy .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Create the SQLite database file
touch database/database.sqlite    # on Windows PowerShell: New-Item database/database.sqlite

# 7. Create the tables and load the demo data
php artisan migrate --seed

# 8. Build the frontend assets
npm run build

# 9. Start the development server
php artisan serve
```

Open **http://127.0.0.1:8000** in your browser.

---

## Database

**The database file is deliberately not included in this repository.** Committing a
`.sqlite` file or a SQL dump would mean shipping real user records and password
hashes, and the file would conflict on every pull. Instead, the database is
reproduced from code:

- **Schema** lives in `database/migrations/` — one migration per table or column change.
- **Data** lives in `database/seeders/` — demo trainers, group classes, and accounts.
- **Membership plans** are inserted by their own migration
  (`..._create_membership_plans_table.php`), because the app cannot render its
  pricing page without them.

So `php artisan migrate --seed` gives you a complete, working database from scratch.
All seeders use `updateOrCreate`, which means running them twice is safe and will
never produce duplicates.

### Demo accounts

The seeder creates two accounts so you can log in immediately:

| Role | Email | Password |
|---|---|---|
| Administrator | `admin@technogym.test` | `password` |
| Member | `member@technogym.test` | `password` |

The admin panel is at **`/admin`** and is only reachable by an account with
`is_admin = true`.

> ⚠️ These are demo credentials for local development. Change them before deploying
> anywhere that is reachable from the internet.

### Resetting the database

To wipe everything and start over with fresh demo data:

```bash
php artisan migrate:fresh --seed
```

### Using MySQL instead of SQLite

SQLite is the default because it needs no server and no configuration. If you would
rather use MySQL or MariaDB, create an empty database and edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=technogym
DB_USERNAME=root
DB_PASSWORD=
```

Then run `php artisan migrate --seed`. No other change is needed — the migrations
work on both engines.

---

## Development

Run all dev processes at once (PHP server, queue worker, log viewer, and Vite with
hot reload):

```bash
composer run dev
```

Or run them individually:

```bash
php artisan serve     # http://127.0.0.1:8000
npm run dev           # Vite dev server with hot module replacement
```

**Note on assets:** `public/build/` is not committed, since it is generated output.
After cloning — and after any change to `resources/css/` or `resources/js/` — run
`npm run build` (or keep `npm run dev` running).

### Other commands

```bash
php artisan test              # run the test suite
./vendor/bin/pint             # format PHP code (Laravel Pint)
php artisan route:list        # list all routes
php artisan migrate:status    # show which migrations have run
```

---

## Project structure

```
app/
  Http/Controllers/          Public-facing controllers
  Http/Controllers/Admin/    Admin panel controllers
  Http/Middleware/           Includes the admin-only gate
  Models/                    Eloquent models
database/
  migrations/                Table definitions
  seeders/                   Demo data
resources/
  css/app.css                Bootstrap import + the whole custom theme
  js/app.js                  Bootstrap JS entry point
  views/
    layouts/app.blade.php    Public layout (navbar + footer)
    layouts/admin.blade.php  Admin layout (sidebar + topbar)
    admin/                   Admin panel views
routes/
  web.php                    All routes
```

### Main routes

| Route | Description |
|---|---|
| `/` | Home page |
| `/treneri` | Trainer listing |
| `/treneri/{trainer}` | Trainer profile and session booking |
| `/clanarine` | Membership plans |
| `/clanarina/{plan}/kupovina` | Membership checkout |
| `/dashboard` | Member dashboard (login required) |
| `/admin` | Admin dashboard (admin only) |

---

## Theming

All colors are defined as CSS custom properties at the top of
`resources/css/app.css`, so the whole site can be re-themed from one place:

```css
:root {
  --accent:   #cc2200;   /* brand red — navigation and marketing buttons */
  --success:  #15803d;   /* green — save, confirm, sign up */
  --danger:   #cc3d3d;   /* red — delete, cancel */
  --bg-dark:  #0c0c0c;   /* page background */
}
```

Buttons follow a semantic convention: `.btn-success` for actions that create or
confirm something, `.btn-outline-danger` for actions that delete or cancel, and
`.btn-accent` for navigation and marketing calls to action.

---

## Security notes

- `.env` is git-ignored and must never be committed — it holds your `APP_KEY` and
  database credentials. Use `.env.example` as the template.
- The database file is git-ignored for the same reason.
- Set `APP_DEBUG=false` and `APP_ENV=production` before deploying.

---

## License

Released under the [MIT License](https://opensource.org/licenses/MIT).
