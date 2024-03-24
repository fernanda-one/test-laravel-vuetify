## README - Laravel Backend & Vue 3 Frontend Application

### Deskripsi Aplikasi
Aplikasi ini adalah sebuah platform web e-commerce sederhana yang dikembangkan menggunakan Laravel 7.4 sebagai backend dan Vue 3 dengan Vuetify sebagai frontend. Aplikasi ini bertujuan untuk memberikan pengalaman belanja online yang nyaman bagi pengguna.

### Instalasi Backend
1. Pastikan Anda telah menginstal PHP 7.4, Composer, PostgreSQL, dan Node.js di komputer Anda.
2. Clone repositori ini ke dalam folder lokal Anda.
3. Buka terminal dan masuk ke dalam direktori `backend`.
4. Buatlah file `.env` baru berdasarkan contoh `.env.example`.
5. Konfigurasikan file `.env` sesuai dengan pengaturan database dan lingkungan lainnya.
6. Jalankan perintah `composer install` untuk menginstal semua dependensi PHP.
7. Jalankan perintah `php artisan key:generate` untuk menghasilkan kunci aplikasi baru.
8. Jalankan perintah `php artisan migrate --seed` untuk menjalankan migrasi database.

### Instalasi Frontend
1. Buka terminal dan masuk ke dalam direktori `frontend`.
2. Jalankan perintah `npm install` untuk menginstal semua dependensi Vue.js.
3. Jalankan perintah `npm run dev` untuk memulai server pengembangan Vue.js.

