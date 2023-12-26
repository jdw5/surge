# Surge 
By Joshua Wallace

## What is it?
Surge is a complete boilerplate for Laravel + Vue + Inertia. It includes:
- Artisan commands for scaffolding
- Authentication implemented on top of Fortify
- Base packages 
- Complete component library written with TailwindCSS and HeadlessUI
- Modal pages via Momentum Modal
- Stripe integration, available through Action classes and built on top of Cashier
- Completely configured frontend development environment with Typescript
- Use of Spatie's Laravel Data package for data transformation and connection between Javascript and PHP

## Installation
```console
composer require jdw5/surge
```

When installed:
```
php artisan surge:install
```

This will install all other packages and copy the necessary files to your project. Once installed, ensure the dependencies are installed and the migrations run:
```console
npm install && npm run dev
php artisan migrate
```

Once installed, do **not** run the `surge:install` command again as this can overwrite file changes. To update dependencies in future, you can reference the publically available `stubs/package.json` and `stubs/.composer.json` files.