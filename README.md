# Hospital Management System

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## Requirements

- PHP >= 8.1  
- Composer  
- MySQL
- Node.js  

## Installation

Clone repository:
```bash
git clone https://github.com/username/hospital-management.git
cd hospital-management
```

Install dependencies:
```bash
composer install
npm install
```

Copy environment file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

Konfigurasi database di file `.env`.

Jalankan migration & seeding (jika ada seeder):
```bash
php artisan migrate --seed
```

Compile frontend assets
```bash
npm run dev
```

## Running the Project

Jalankan Laravel development server:
```bash
php artisan serve
```

Akses di:  
👉 [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Features

- CRUD Pasien  
- CRUD Rumah Sakit

## License

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
