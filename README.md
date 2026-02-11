# EduCare - Sistem Pengaduan Sarana dan Prasarana Sekolah

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1.svg)

## Deskripsi

**EduCare** adalah sistem web berbasis PHP untuk mengelola pengaduan sarana dan prasarana sekolah. Sistem ini memungkinkan siswa untuk mengajukan aspirasi/keluhan terkait fasilitas sekolah, dan admin dapat mengelola, memantau, serta memberikan feedback terhadap pengaduan tersebut.

## Fitur Utama

###  Portal Siswa
- **Pengajuan Aspirasi**: Form mudah untuk mengajukan keluhan fasilitas
- **Tracking Status**: Monitor progress aspirasi secara real-time
- **History Timeline**: Riwayat lengkap aspirasi dengan timeline
- **Feedback System**: Menerima feedback dari administrator

###  Panel Admin
- **Dashboard Analytics**: Statistik dan visualisasi data aspirasi
- **Manajemen Aspirasi**: CRUD lengkap dengan filter dan pencarian
- **Master Data**: Kelola kategori dan lokasi fasilitas
- **Sistem Laporan**: Export PDF dan Excel dengan formatting profesional
- **Audit Trail**: Log lengkap perubahan data

##  Teknologi

- **Backend**: PHP 8.0+ dengan PDO
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Database**: MySQL 5.7+
- **Architecture**: MVC (Model-View-Controller)
- **Security**: Password hashing, SQL injection prevention, XSS protection

##  Instalasi

### Persyaratan Sistem
- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web Server (Apache)
- Composer (opsional, untuk PDF export)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/ekazahrosafitri6-dot/Educare_ukk2026.git
   cd Educare_ukk2026
   ```

2. **Konfigurasi Database**
   ```bash
   # Edit file config/database.php
   # Atau set environment variables:
   # DB_HOST=localhost
   # DB_NAME=db_pengajuan
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

3. **Setup Database**
   ```bash
   php setup_database.php
   ```

4. **Install Dependencies (Opsional)**
   ```bash
   php composer.phar install
   ```

5. **Jalankan Server**
   ```bash
   php -S localhost:8000 -t public/
   ```

## Penggunaan

### Akses Aplikasi
- **Portal Siswa**: `http://localhost:8000/student`
- **Panel Admin**: `http://localhost:8000/admin`
- **Halaman Utama**: `http://localhost:8000/`

### Login Default Admin
- **Username**: admin
- **Password**: admin123

## Database Schema

Aplikasi menggunakan database `db_pengajuan` dengan tabel utama:
- `admin` - Akun administrator
- `siswa` - Informasi siswa
- `kategori` - Kategori keluhan
- `lokasi` - Lokasi fasilitas
- `input_aspirasi` - Form input aspirasi
- `aspirasi` - Tracking aspirasi
- `audit_trail` - Log perubahan

## Struktur Project

```
├── config/                 # File konfigurasi
├── controllers/            # Controller classes (MVC)
├── models/                 # Model classes (MVC)
├── views/                  # View templates (MVC)
│   ├── admin/             # Interface admin
│   └── student/           # Interface siswa
├── public/                 # File web publik
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── index.php          # Entry point aplikasi
└── vendor/                # Composer dependencies
```

## Fitur Keamanan

- **Session Management**: Autentikasi aman dengan timeout
- **Prepared Statements**: Pencegahan SQL injection
- **Input Validation**: Perlindungan XSS
- **Audit Trail**: Tracking lengkap perubahan data
- **Password Hashing**: Enkripsi password yang aman

## Status Aspirasi

- **Menunggu** - Menunggu review
- **Proses** - Sedang ditangani
- **Selesai** - Sudah diselesaikan

## Kontribusi

Project ini dikembangkan untuk tujuan memenuhi penilaian Ujian Keahlihan Kopentensi. Kontribusi dan saran sangat diterima!

## Lisensi

Project ini dikembangkan untuk tujuan edukasi dan pembelajaran.

## Tim Pengembang

- **Developer**: Eka zahro safitri
- **Project**: Educare

## Kontak

Jika ada pertanyaan atau masalah, silakan hubungi:
- **Email**: [ekazahrosafitri6@gmail.com]
- **GitHub**: [@ekazahrosafitri6-dot](https://github.com/ekazahrosafitri6-dot)

---

**EduCare - Membangun Komunikasi yang Lebih Baik Antara Siswa dan Sekolah** 
