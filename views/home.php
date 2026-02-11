<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCare - Sistem Pengaduan Sarana Sekolah</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Header & Navigation */
        .header {
            background: white;
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0;
            box-shadow: 0 2px 12px rgba(46, 90, 167, 0.1);
            border-bottom: 3px solid var(--sea-breeze);
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
            color: var(--amalf);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .logo:hover {
            color: var(--primary-700);
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
            box-shadow: 0 4px 12px rgba(138, 177, 245, 0.2);
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
            color: var(--primary-800);
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
            background: linear-gradient(90deg, var(--sea-breeze), var(--amalfi-tile));
            transition: width 0.3s;
        }
        
        .nav-menu a:hover {
            color: var(--amalfi-tile);
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
            border: 2px solid var(--sea-breeze);
            color: var(--amalfi-tile);
            background: transparent;
        }
        
        .btn-outline:hover {
            border-color: var(--amalfi-tile);
            background: var( --cream-gelato);
             color: var(--amalfi-tile);
        }
        
        .btn-primary {
            background: var(--primary-900);
            color: white;
            border: 2px solid transparent;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 90, 167, 0.3);
            background: var( --cream-gelato);
            color: var(--primary-700)
        }
        
        /* Hero Section */
        .hero {
            background: var(--primary-900) ;
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .hero-text {
            text-align: center;
        }
        
        .hero-text h1 {
            font-size: 56px;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 24px;
            color: white;
        }
        
        .hero-text p {
            font-size: 20px;
            color: white;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
          
        }
        
        .btn-hero {
            padding: 16px 32px;
            font-size: 16px;
            border-radius: 12px;
            background: var(--citrus-zest);
        }
        
        .btn-secondary {
            background: var(--citrus-zest);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: var(--cream-gelato);
            border-color: rgba(255, 255, 255, 0.3);
            color: var(--primary-800)
        }
        
        .hero-visual {
            position: relative;
        }
        
        .hero-card {
            background: var(--primary-900);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
        }
        
        .hero-card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--citrus-zest), var(--warning-600));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 36px;
        }
        
        .hero-card h3 {
            font-size: 24px;
            margin-bottom: 12px;
            color: white;
        }
        
        .hero-card p {
            color: var(--neutral-100);
            font-size: 16px;
        }
        
        /* Features Section */
        .features {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--neutral-50), white);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }
        
        .section-subtitle {
            color: var(--sea-breeze);
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section-title {
            font-size: 48px;
            font-weight: 700;
            color: var(--amalfi-tile);
            margin-bottom: 24px;
        }
        
        .section-description {
            font-size: 20px;
            color: var(--primary-800);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(46, 90, 167, 0.05);
            transition: all 0.3s;
            border: 2px solid var(--sea-breeze);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(46, 90, 167, 0.15);
            border-color: var(--amalfi-tile);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-900);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            font-size: 24px;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 24px;
            font-weight: 600;
            color: var(--amalfi-tile);
            margin-bottom: 16px;
        }
        
        .feature-card p {
            color: var(--primary-900);
            line-height: 1.6;
            margin-bottom: 24px;
        }
        
        .feature-list {
            list-style: none;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary-900);
            margin-bottom: 8px;
        }
        
        .feature-list li::before {
            content: '✓';
            color: var(--success-600);
            font-weight: bold;
            width: 20px;
            height: 20px;
            background: var(--success-50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        
        /* Stats Section */
        .stats {
            background: var(--primary-900);
            color: white;
            padding: 80px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
        }
        
        .stat-label {
            font-size: 16px;
            color: var(--neutral-100);
            font-weight: 500;
        }
        
        /* Services Section */
        .services {
            padding: 100px 0;
            background: white;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(46, 90, 167, 0.05);
            border: 2px solid var(--sea-breeze);
            transition: all 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(46, 90, 167, 0.15);
            border-color: var(--amalfi-tile);
        }
        
        .service-image {
            height: 200px;
            background:var(--citrus-zest);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
        }
        
        .service-content {
            padding: 30px;
        }
        
        .service-card h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--amalfi-tile);
            margin-bottom: 12px;
        }
        
        .service-card p {
            color: var(--primary-800);
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .service-link {
            color: var(--sea-breeze);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .service-link:hover {
            color: var(--amalfi-tile);
        }
        
        /* Footer */
        .footer {
            background: var(--amalfi-tile);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-brand h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: white;
        }
        
        .footer-brand p {
            color: white;
            line-height: 1.6;
        }
        
        .footer-section h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .footer-links li .icon {
            color: white !important;
            margin-right: 8px;
            flex-shrink: 0;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary-900);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(245, 245, 245, 0.2);
            padding-top: 30px;
            text-align: center;
            color: var(--neutral-100);
        }
        .footer-bottom p{
            color: white;
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
                gap: 8px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 13px;
            }
            
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .hero-text h1 {
                font-size: 36px;
            }
            
            .section-title {
                font-size: 32px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            background: transparent;
            border: 2px solid var(--sea-breeze);
            border-radius: 8px;
            color: var(--amalfi-tile);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .mobile-menu-btn:hover {
            background: var(--sea-breeze);
            color: white;
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
              Educare
            </a>
            
            <ul class="nav-menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            
            <div class="nav-cta">
                <a href="/student" class="btn btn-outline">Portal Siswa</a>
                <a href="/admin" class="btn btn-primary">Login Admin</a>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <div class="icon icon-menu icon-sm"></div>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Wujudkan Sekolah Impian Bersama EduCare</h1>
                    <p>Platform digital terdepan untuk menyampaikan aspirasi dan pengaduan fasilitas sekolah. Bersama-sama kita tingkatkan kualitas pendidikan melalui sarana dan prasarana yang lebih baik.</p>
                    
                    <div class="hero-buttons">
                        <a href="/student" class="btn btn-primary btn-hero">
                            <div class="icon icon-pencil icon-md"></div>
                            Mulai Pengaduan
                        </a>
                        <a href="#layanan" class="btn btn-secondary btn-hero">
                            <div class="icon icon-clipboard icon-md"></div>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="fitur">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Fitur Unggulan</div>
                <h2 class="section-title">Solusi Lengkap untuk Pengaduan Sekolah</h2>
                <p class="section-description">
                    Kami menyediakan berbagai fitur canggih untuk memastikan setiap aspirasi siswa tersampaikan dan tertangani dengan baik
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <div class="icon icon-pencil icon-lg"></div>
                    </div>
                    <h3>Pengaduan Online</h3>
                    <p>Sistem pengaduan digital yang mudah digunakan dengan antarmuka yang intuitif dan responsif.</p>
                    <ul class="feature-list">
                        <li>Form pengaduan yang mudah</li>
                        <li>Upload foto pendukung</li>
                        <li>Kategorisasi otomatis</li>
                        <li>Notifikasi real-time</li>
                    </ul>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <div class="icon icon-chart-bar icon-lg"></div>
                    </div>
                    <h3>Tracking & Monitoring</h3>
                    <p>Pantau progress penyelesaian pengaduan secara real-time dengan sistem tracking yang akurat.</p>
                    <ul class="feature-list">
                        <li>Status real-time</li>
                        <li>Timeline progress</li>
                        <li>Estimasi penyelesaian</li>
                        <li>Riwayat lengkap</li>
                    </ul>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <div class="icon icon-chat icon-lg"></div>
                    </div>
                    <h3>Komunikasi Interaktif</h3>
                    <p>Sistem komunikasi dua arah yang memungkinkan dialog konstruktif antara siswa dan admin.</p>
                    <ul class="feature-list">
                        <li>Feedback langsung</li>
                        <li>Chat support</li>
                        <li>Update berkala</li>
                        <li>Rating kepuasan</li>
                    </ul>
                </div>
                
            </div>
        </div>
    </section>



    <!-- Services Section -->
    <section class="services" id="layanan">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Layanan Kami</div>
                <h2 class="section-title">Berbagai Jenis Layanan Pengaduan</h2>
                <p class="section-description">
                    Kami melayani berbagai jenis pengaduan fasilitas sekolah untuk menciptakan lingkungan belajar yang optimal
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-image">
                        <div class="icon icon-school icon-2xl"></div>
                    </div>
                    <div class="service-content">
                        <h3>Fasilitas Ruang Kelas</h3>
                        <p>Pengaduan terkait kondisi ruang kelas, AC, proyektor, papan tulis, dan peralatan pembelajaran lainnya.</p>
                        <a href="/student" class="service-link">
                            Ajukan Pengaduan →
                        </a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-image">
                        <div class="icon icon-beaker icon-2xl"></div>
                    </div>
                    <div class="service-content">
                        <h3>Laboratorium</h3>
                        <p>Laporan kerusakan atau kekurangan alat laboratorium, ventilasi, dan fasilitas keselamatan lab.</p>
                        <a href="/student" class="service-link">
                            Ajukan Pengaduan →
                        </a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-image">
                        <div class="icon icon-droplets icon-2xl"></div>
                    </div>
                    <div class="service-content">
                        <h3>Sanitasi & Kebersihan</h3>
                        <p>Pengaduan fasilitas toilet, tempat cuci tangan, kebersihan lingkungan, dan sistem sanitasi sekolah.</p>
                        <a href="/student" class="service-link">
                            Ajukan Pengaduan →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>EduCare</h3>
                    <p>Platform digital terdepan untuk sistem pengaduan sarana dan prasarana sekolah. Bersama-sama kita wujudkan lingkungan pendidikan yang lebih baik.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="/student">Portal Siswa</a></li>
                        <li><a href="/admin">Portal Admin</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#layanan">Bantuan</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Informasi</h4>
                    <ul class="footer-links">
                        <li><a href="#beranda">Tentang Kami</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                        <li><a href="#beranda">Kebijakan Privasi</a></li>
                        <li><a href="#beranda">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul class="footer-links">
                        <li><div class="icon icon-mail icon-sm"></div> info@educare.sch.id</li>
                        <li><div class="icon icon-phone icon-sm"></div> (021) 1234-5678</li>
                        <li><div class="icon icon-location icon-sm"></div> Jakarta, Indonesia</li>
                        <li><div class="icon icon-clock icon-sm"></div> Senin - Jumat, 08:00-16:00</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 EduCare - Sistem Pengaduan Sarana Sekolah. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>