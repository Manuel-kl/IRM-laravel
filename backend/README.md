# Simple Laravel User management CRUD API

## Features

-   Authentication
     - Registration
     - Login
     - Logout

-   User Authorizations based on roles
     - Admin users
     - Normal users

-  CRUD operations for managing users/and managing personal accounts

## Installation

Clone the repo locally:

```sh
git clone https://github.com/Manuel-kl/IRM-laravel
cd IRM-laravel
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Open the `.env` file and setup your database username and password

```
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Generate application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder (To seed default admin user):
email: admin@example.com
password: password

```sh
php artisan db:seed
```

Run the development server:

```sh
php artisan serve
```