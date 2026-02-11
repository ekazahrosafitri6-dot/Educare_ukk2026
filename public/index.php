<?php

/**
 * Application Entry Point
 * 
 * Main entry point for the School Facility Complaint Application
 */

// Start session
session_start();  // Mulai PHP session untuk menyimpan data user

// Set error reporting for development
error_reporting(E_ALL);                    // Tampilkan semua jenis error
ini_set('display_errors', 1);              // Tampilkan error di browser
ini_set('display_startup_errors', 1);      // Tampilkan error saat startup

// Define application root
define('APP_ROOT', dirname(__DIR__));  // Definisikan root directory aplikasi

// Use real Database connection
require_once __DIR__ . '/../models/Database.php';  // Load class Database

// Include required files
require_once __DIR__ . '/../controllers/AdminController.php';    // Load AdminController
require_once __DIR__ . '/../controllers/StudentController.php';  // Load StudentController

// Basic routing
$request = $_SERVER['REQUEST_URI'] ?? '/';     // Ambil URI yang diminta user
$path = parse_url($request, PHP_URL_PATH);     // Parse URL untuk mendapatkan path saja
$path = ltrim($path, '/');                     // Hapus slash di awal path

// Initialize controllers
$adminController = new AdminController();      // Buat instance AdminController
$studentController = new StudentController();  // Buat instance StudentController

// Routing logic - menentukan halaman mana yang akan ditampilkan berdasarkan URL
switch ($path) {
    case '':                    // Jika path kosong (root URL)
    case 'index.php':           // Atau jika mengakses index.php langsung
        include __DIR__ . '/../views/home.php';  // Tampilkan halaman beranda
        break;
        
    case 'student':             // Jika mengakses /student
        // Tampilkan portal siswa
        $portalFile = __DIR__ . '/../views/student/portal.php';  // Path file portal
        if (file_exists($portalFile)) {                          // Cek apakah file ada
            include $portalFile;                                 // Include file jika ada
        } else {
            die('Error: Portal file not found at: ' . $portalFile);  // Error jika file tidak ada
        }
        break;
        
    case 'student/portal':           // Jika mengakses /student/portal
        // Tampilkan portal terintegrasi siswa
        $studentController->showIntegratedPortal();  // Panggil method showIntegratedPortal
        break;
        
    case 'student/portal-integrated':  // Route alternatif untuk portal terintegrasi
        // Tampilkan portal terintegrasi siswa (route alternatif)
        $studentController->showIntegratedPortal();  // Panggil method yang sama
        break;
        
    case 'student/aspiration':       // Jika mengakses /student/aspiration
        $studentController->showAspirationForm();  // Tampilkan form pengajuan aspirasi
        break;
        
    case 'student/submit':           // Jika mengakses /student/submit
        $studentController->submitAspiration();    // Proses pengajuan aspirasi
        break;
        
    case 'student/feedback':         // Jika mengakses /student/feedback
        $studentController->showFeedback();       // Tampilkan halaman feedback
        break;
        
    case 'student/history':          // Jika mengakses /student/history
        $studentController->viewHistory();        // Tampilkan halaman history
        break;
        
    // API endpoints untuk portal terintegrasi
    case 'api/student/feedback':             // API endpoint untuk data feedback
        header('Content-Type: application/json');  // Set header response JSON
        $studentController->getFeedbackAPI();       // Panggil method API feedback
        break;
        
    case 'api/student/history':              // API endpoint untuk data history
        header('Content-Type: application/json');  // Set header response JSON
        $studentController->getHistoryAPI();        // Panggil method API history
        break;
        
    // Legacy API endpoints (untuk backward compatibility)
    case 'student/api/feedback':             // API endpoint lama untuk feedback
        header('Content-Type: application/json');  // Set header response JSON
        $studentController->getFeedbackAPI();       // Panggil method yang sama
        break;
        
    case 'student/api/history':              // API endpoint lama untuk history
        header('Content-Type: application/json');  // Set header response JSON
        $studentController->getHistoryAPI();        // Panggil method yang sama
        break;
        

        
    case 'admin':                            // Jika mengakses /admin
    case 'admin/login':                      // Atau /admin/login
        $adminController->showLogin();       // Tampilkan halaman login admin
        break;
        
    case 'admin/authenticate':               // Jika mengakses /admin/authenticate
        $adminController->authenticate();    // Proses autentikasi admin
        break;
        
    case 'admin/dashboard':                  // Jika mengakses /admin/dashboard
        $adminController->showDashboard();   // Tampilkan dashboard admin
        break;
        
    case 'admin/logout':                     // Jika mengakses /admin/logout
        $adminController->logout();          // Proses logout admin
        break;
        
    case 'admin/check-auth':                 // API untuk cek status autentikasi
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->checkAuth();              // Panggil method check auth
        break;
        
    case 'admin/aspirations':                // Jika mengakses /admin/aspirations
        $adminController->manageAspirations(); // Tampilkan halaman kelola aspirasi
        break;
        
    case 'admin/update-status':              // API untuk update status aspirasi
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->updateStatus();           // Panggil method update status
        break;
        
    case 'admin/add-feedback':               // API untuk menambah feedback
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->addFeedback();            // Panggil method add feedback
        break;
        
    case 'admin/delete-aspiration':          // API untuk menghapus aspirasi
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->deleteAspiration();       // Panggil method delete aspiration
        break;
        
    case 'admin/search':                     // API untuk pencarian aspirasi
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->searchAspirations();      // Panggil method search (jika ada)
        break;
        
    case 'admin/aspiration-detail':          // Halaman detail aspirasi
        $adminController->viewAspirationDetail();   // Tampilkan detail aspirasi
        break;
        
    case 'admin/settings':                   // Halaman pengaturan admin
        $adminController->showSettings();           // Tampilkan halaman settings
        break;
        
    case 'admin/categories':                 // Halaman kelola kategori
        $adminController->manageCategories();       // Tampilkan halaman kelola kategori
        break;
        
    case 'admin/categories/detail':          // API untuk detail kategori
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->getCategoryDetail();      // Panggil method get category detail
        break;
        
    case 'admin/locations':                  // Halaman kelola lokasi
        $adminController->manageLocations();        // Tampilkan halaman kelola lokasi
        break;
        
    case 'admin/locations/detail':           // API untuk detail lokasi
        header('Content-Type: application/json');  // Set header response JSON
        $adminController->getLocationDetail();      // Panggil method get location detail
        break;
        
    case 'admin/reports':                    // Halaman laporan
        $adminController->showReports();            // Tampilkan halaman laporan
        break;
        
    case 'admin/reports/export-pdf':         // Export laporan ke PDF
        $adminController->exportReportToPDF();      // Panggil method export PDF
        break;
        
    case 'admin/reports/export-excel':       // Export laporan ke Excel
        $adminController->exportReportToExcel();    // Panggil method export Excel
        break;
        
    // CSS and JS files - serving static assets
    case 'css/style.css':                    // Jika mengakses file CSS
        header('Content-Type: text/css');    // Set header content type CSS
        readfile(__DIR__ . '/css/style.css'); // Baca dan output file CSS
        break;
        
    case 'js/student-portal.js':             // Jika mengakses file JavaScript
        header('Content-Type: application/javascript'); // Set header content type JS
        readfile(__DIR__ . '/js/student-portal.js');    // Baca dan output file JS
        break;
        
    case 'js/admin-auth-guard.js':           // Jika mengakses file JavaScript auth guard
        header('Content-Type: application/javascript'); // Set header content type JS
        readfile(__DIR__ . '/js/admin-auth-guard.js');  // Baca dan output file JS
        break;
        
    default:                                 // Jika URL tidak ditemukan (404)
        http_response_code(404);             // Set HTTP status code 404
        echo "<h1>404 - Page Not Found</h1>"; // Tampilkan pesan error
        echo "<a href='/'>← Kembali ke Beranda</a>"; // Link kembali ke beranda
        break;
}