<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background: white;
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0;
            box-shadow: 0 2px 12px rgba(0, 56, 188, 0.1);
            border-bottom: 3px solid var(--secondary-600);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-900);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .logo:hover {
            color: var(--primary-800);
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--primary-900);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(0, 56, 188, 0.2);
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 40px;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu a {
            text-decoration: none;
            color: #1d3a6d;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
            position: relative;
            padding: 8px 0;
        }
        
        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background:var(--primary-900);
            transition: width 0.3s;
        }
        
        .nav-menu a:hover {
            color: var(--primary-900);
        }
        
        .nav-menu a:hover::after {
            width: 100%;
        }
        
        .nav-cta {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn {
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-outline {
            border: 2px solid var(--secondary-600);
            color: var(--primary-900);
            background: transparent;
        }
        
        .btn-outline:hover {
            border-color: var(--primary-900);
            background: var(--sea-breeze);
            color: var(--primary-900);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-900), var(--primary-800));
            color: white;
            border: 2px solid transparent;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 56, 188, 0.3);
            background: var(--primary-600);
        }
        
        /* Hero Section */
        .hero {
            background: var(--primary-900);
            color: white;
            padding: 120px 20px 80px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 24px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .hero p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto 40px;
            line-height: 1.6;
            color: white;
            opacity: 1;
        }
        
        /* Services Section */
        .services {
            padding: 80px 20px;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-subtitle {
            color: var(--primary-600);
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .section-title {
            font-size: 42px;
            font-weight: 700;
            color: var(--primary-900);
            margin-bottom: 24px;
        }
        
        .section-description {
            font-size: 18px;
            color: #334155;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .service-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-600);
        }
        
        .service-image {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            color: white;
        }
        
        .service-image.primary {
            background:  var(--primary-900);
        }
        
        .service-image.secondary {
            background: var(--primary-900);
        }
        
        .service-image.warning {
            background: var(--citrus-zest);
        }
        
        .service-content {
            padding: 30px;
        }
        
        .service-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        
        .service-card p {
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 15px;
        }
        
        .service-link {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }
        
        .service-link:hover {
            color: var(--primary-800);
        }
        
        /* Footer */
        .footer {
            background: var(--primary-900);
            color: white;
            padding: 40px 20px 20px;
            text-align: center;
        }
        
        .footer p {
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            font-size: 14px;
        }
        
        /* Icons */
        .icon {
            width: 1em;
            height: 1em;
            display: inline-block;
        }
        
        .icon-school {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 16h6M7 8h6v4H7V8z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .icon-pencil {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .icon-chat {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .icon-clock {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .icon-sm {
            width: 0.875rem;
            height: 0.875rem;
        }
        
        .icon-md {
            width: 1.25rem;
            height: 1.25rem;
        }
        
        .icon-lg {
            width: 1.5rem;
            height: 1.5rem;
        }
        
        .icon-xl {
            width: 2rem;
            height: 2rem;
        }
        
        .icon-2xl {
            width: 2.5rem;
            height: 2.5rem;
        }
        
        .icon-3xl {
            width: 3rem;
            height: 3rem;
        }
        
        .icon-4xl {
            width: 4rem;
            height: 4rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                height: 60px;
                padding: 0 15px;
            }
            
            .logo {
                font-size: 20px;
            }
            
            .logo-icon {
                width: 38px;
                height: 38px;
                font-size: 18px;
            }
            
            .nav-menu {
                display: none;
            }
            
            .nav-cta {
                display: none;
            }
            
            .mobile-menu-btn {
                display: flex;
            }
            
            .hero h1 {
                font-size: 32px;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            background: transparent;
            border: 2px solid var(--secondary-600);
            border-radius: 8px;
            color: var(--primary-900);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .mobile-menu-btn:hover {
            background: var(--secondary-600);
            color: white;
        }
        
        .icon-menu {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h16M4 18h16'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <div class="icon icon-school icon-xl"></div>
                </div>
                EduCare
            </a>
            
            
            <div class="nav-cta">
                <a href="/" class="btn btn-outline">Beranda</a>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <div class="icon icon-menu icon-md"></div>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Portal Siswa EduCare</h1>
        <p>Sampaikan aspirasi dan pengaduan fasilitas sekolah Anda dengan mudah. Pantau progress penyelesaian dan dapatkan feedback langsung dari pihak sekolah.</p>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="section-header">
            <div class="section-subtitle">Layanan Siswa</div>
            <h2 class="section-title">Fitur Portal Siswa</h2>
            <p class="section-description">
                Akses berbagai layanan untuk menyampaikan aspirasi dan memantau progress pengaduan Anda dengan mudah
            </p>
        </div>
        
        <div class="services-grid">
            <a href="/student/aspiration" class="service-card">
                <div class="service-image primary">
                    <div class="icon icon-pencil icon-4xl"></div>
                </div>
                <div class="service-content">
                    <h3>Ajukan Aspirasi</h3>
                    <p>Sampaikan pengaduan atau aspirasi terkait sarana dan prasarana sekolah. Pilih dari 4 kategori: Kerusakan Sarana, Kekurangan Sarana, Penggantian Sarana, atau Keamanan & Keselamatan.</p>
                    <span class="service-link">
                        Mulai Pengaduan →
                    </span>
                </div>
            </a>
            
            <a href="/student/feedback" class="service-card">
                <div class="service-image secondary">
                    <div class="icon icon-chat icon-4xl"></div>
                </div>
                <div class="service-content">
                    <h3>Status & Progress</h3>
                    <p>Cek status dan feedback dari admin sekolah terhadap aspirasi yang telah Anda sampaikan. Pantau progres perbaikan dengan timeline detail.</p>
                    <span class="service-link">
                        Cek Status & Progress →
                    </span>
                </div>
            </a>
            
            <a href="/student/history" class="service-card">
                <div class="service-image warning">
                    <div class="icon icon-clock icon-4xl"></div>
                </div>
                <div class="service-content">
                    <h3>Riwayat Aspirasi</h3>
                    <p>Lihat histori lengkap semua aspirasi yang pernah Anda ajukan beserta status penyelesaiannya.</p>
                    <span class="service-link">
                        Lihat Riwayat →
                    </span>
                </div>
            </a>
        </div>
    </section>

    <!-- How to Use Section -->
    <section style="padding: 60px 20px; background: #f8fafc;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div class="section-header">
                <div class="section-subtitle">Panduan Penggunaan</div>
                <h2 class="section-title">Cara Menggunakan Portal Siswa</h2>
                <p class="section-description">
                    Ikuti langkah-langkah sederhana berikut untuk menggunakan portal siswa
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 2px solid #e2e8f0;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-900), var(--primary-600)); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px; color: white;">1️⃣</span>
                    </div>
                    <h3 style="color: #0f172a; margin-bottom: 12px; font-size: 18px;">Isi Form Aspirasi</h3>
                    <p style="color: #475569; margin: 0; line-height: 1.6;">
                        Masukkan NIS, kelas, pilih kategori pengaduan, lokasi, dan jelaskan detail masalah yang ingin dilaporkan.
                    </p>
                </div>
                
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 2px solid #e2e8f0;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0ea5e9, #06b6d4); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px; color: white;">2️⃣</span>
                    </div>
                    <h3 style="color: #0f172a; margin-bottom: 12px; font-size: 18px;">Pantau Status</h3>
                    <p style="color: #475569; margin: 0; line-height: 1.6;">
                        Gunakan NIS untuk melihat status pengaduan: Menunggu, Proses, atau Selesai. Dapatkan feedback dari admin.
                    </p>
                </div>
                
                <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 2px solid #e2e8f0;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px; color: white;">3️⃣</span>
                    </div>
                    <h3 style="color: #0f172a; margin-bottom: 12px; font-size: 18px;">Lihat Progres</h3>
                    <p style="color: #475569; margin: 0; line-height: 1.6;">
                        Pantau progres perbaikan secara real-time dengan timeline detail dan riwayat lengkap semua aspirasi.
                    </p>
                </div>
            </div>
            
            <!-- Important Notes -->
            <div style="background: white; border-radius: 16px; padding: 30px; margin-top: 40px; border: 2px solid #dbeafe;">
                <h3 style="color: var(--primary-800); margin: 0 0 20px 0; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>ℹ️</span> Informasi Penting
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <div>
                        <h4 style="color: #0f172a; margin: 0 0 8px 0; font-size: 16px;">📋 Kategori Pengaduan</h4>
                        <ul style="color: #475569; margin: 0; padding-left: 20px; line-height: 1.6;">
                            <li><strong>Kerusakan Sarana:</strong> Fasilitas yang rusak</li>
                            <li><strong>Kekurangan Sarana:</strong> Fasilitas yang kurang</li>
                            <li><strong>Penggantian Sarana:</strong> Fasilitas perlu diganti</li>
                            <li><strong>Keamanan & Keselamatan:</strong> Masalah keamanan</li>
                        </ul>
                    </div>
                    <div>
                        <h4 style="color: #0f172a; margin: 0 0 8px 0; font-size: 16px;">⏱️ Status Pengaduan</h4>
                        <ul style="color: #475569; margin: 0; padding-left: 20px; line-height: 1.6;">
                            <li><strong>Menunggu:</strong> Pengaduan baru diterima</li>
                            <li><strong>Proses:</strong> Sedang dalam perbaikan</li>
                            <li><strong>Selesai:</strong> Perbaikan telah selesai</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 EduCare - Sistem Pengaduan Sarana Sekolah. Semua hak dilindungi undang-undang.</p>
    </footer>
</body>
</html>
