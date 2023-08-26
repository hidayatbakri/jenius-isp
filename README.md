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
git clone https://github.com/hidayatbakri/jenius-isp.git
cd jenius-isp
```
```sh
composer install
```
Copy file .env.example kemudian hasil copy tersebut rename menjadi .env
```sh
php artisan key:generate
```
### Konfigurasi env
Setalah melakukan instalasi buka file .env kemudian 
```sh
APP_NAME=Laravel            => APP_NAME=jenius-isp
```
```sh             
DB_DATABASE=laravel         => DB_DATABASE=jenius-isp
```

>> Untuk konfigurasi env yang lengkap silahkan hubungi admin


### Konfigurasi database 
Lanjut di terminal ketikkan :

```sh
php artisan migrate
```

### Menjalankan server
```sh
php artisan serve
```
