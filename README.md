# Internet Service



![Build Status](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) ![Build Status](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black) ![Build Status](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white) ![Build Status](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

## Fitur
- Empty
## Persyaratan
- Php versi 8.0+
- Composer
- Git
## Instalasi

Buka terminal dan ubah direktori masuk ke folder htdocs (Jika menggunakan Xampp) atau folder www (Jika menggunakan laragon)
Contoh:
```sh
cd /xampp/htdocs
```
```sh
cd /laragon/www
```
Setelah itu:
```sh
git clone https://github.com/hidayatbakri/internet-service.git
cd internet-service
```
```sh
composer install
php artisan key:generate
```
Copy file .env.example kemudian hasil copy tersebut rename menjadi .env
### Konfigurasi env
Setalah melakukan instalasi buka file .env kemudian 
```sh
APP_NAME=Laravel            => APP_NAME=internet-service
```
```sh             
DB_DATABASE=laravel         => DB_DATABASE=internet-service
```

>> Untuk yang dibawah 👇, minta lewat Whatsapp
```sh             
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Konfigurasi database 
Lanjut di terminal ketikkan :

```sh
php artisan migrate
```

### Menjalankan server
```sh
php artisan serve
```
