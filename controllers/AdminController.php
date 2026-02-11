<?php

// Database class sudah di-alias di index.php
require_once __DIR__ . '/../models/Admin.php';          // Import model Admin untuk autentikasi
require_once __DIR__ . '/../models/Session.php';        // Import model Session untuk manajemen sesi
require_once __DIR__ . '/../models/Aspiration.php';     // Import model Aspiration untuk kelola aspirasi
require_once __DIR__ . '/../models/Student.php';        // Import model Student untuk data siswa
require_once __DIR__ . '/../models/Category.php';       // Import model Category untuk kelola kategori
require_once __DIR__ . '/../models/Location.php';       // Import model Location untuk kelola lokasi
require_once __DIR__ . '/../models/AuditTrail.php';     // Import model AuditTrail untuk log aktivitas

/**
 * Admin Controller
 * 
 * Handles admin authentication and management functions
 */
class AdminController {
    private Admin $adminModel;          // Instance model Admin untuk operasi admin
    private Session $session;           // Instance model Session untuk manajemen sesi login
    private Aspiration $aspirationModel; // Instance model Aspiration untuk operasi aspirasi
    private Student $studentModel;      // Instance model Student untuk data siswa
    private Category $categoryModel;    // Instance model Category untuk operasi kategori
    private Location $locationModel;    // Instance model Location untuk operasi lokasi
    private AuditTrail $auditTrail;     // Instance model AuditTrail untuk logging

    public function __construct() {
        $this->adminModel = new Admin();           // Inisialisasi model Admin
        $this->session = new Session();            // Inisialisasi model Session
        $this->aspirationModel = new Aspiration(); // Inisialisasi model Aspiration
        $this->studentModel = new Student();       // Inisialisasi model Student
        $this->categoryModel = new Category();     // Inisialisasi model Category
        $this->locationModel = new Location();     // Inisialisasi model Location
        $this->auditTrail = new AuditTrail();      // Inisialisasi model AuditTrail
    }

    /**
     * Show admin login form
     */
    public function showLogin(): void {
        // Jika sudah login dan session belum expired, redirect ke dashboard
        if ($this->session->isLoggedIn() && !$this->session->isExpired()) {
            header('Location: /admin/dashboard');  // Redirect ke dashboard admin
            exit;                                  // Hentikan eksekusi script
        }

        $error = $_SESSION['login_error'] ?? null;  // Ambil pesan error dari session jika ada
        unset($_SESSION['login_error']);            // Hapus pesan error dari session

        include __DIR__ . '/../views/admin/login.php';  // Tampilkan halaman login admin
    }

    /**
     * Process admin login
     */
    public function authenticate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {  // Pastikan request method adalah POST
            header('Location: /admin/login');         // Jika bukan POST, redirect ke login
            exit;                                      // Hentikan eksekusi
        }

        $username = trim($_POST['username'] ?? '');  // Ambil username dari form dan trim whitespace
        $password = $_POST['password'] ?? '';        // Ambil password dari form

        // Validasi input tidak boleh kosong
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Username dan password harus diisi';  // Set pesan error
            header('Location: /admin/login');                                // Redirect ke login
            exit;                                                             // Hentikan eksekusi
        }

        // Coba autentikasi dengan model Admin
        if ($this->adminModel->authenticate($username, $password)) {
            $this->session->login($username);      // Set session login jika berhasil
            header('Location: /admin/dashboard');  // Redirect ke dashboard
            exit;                                  // Hentikan eksekusi
        } else {
            $_SESSION['login_error'] = 'Username atau password salah';  // Set pesan error jika gagal
            header('Location: /admin/login');                           // Redirect ke login
            exit;                                                        // Hentikan eksekusi
        }
    }

    /**
     * Show admin dashboard
     */
    public function showDashboard(): void {
        $this->session->requireAuth();  // Pastikan admin sudah login, jika belum redirect ke login
        
        $username = $this->session->getUsername();              // Ambil username admin yang sedang login
        $statistics = $this->aspirationModel->getStatistics();  // Ambil statistik aspirasi untuk dashboard
        
        include __DIR__ . '/../views/admin/dashboard.php';  // Tampilkan halaman dashboard admin
    }

    /**
     * Check authentication status via AJAX
     */
    public function checkAuth(): void {
        header('Content-Type: application/json');
        
        // Check if admin is logged in and session is not expired
        $isAuthenticated = $this->session->isLoggedIn() && !$this->session->isExpired();
        
        echo json_encode([
            'authenticated' => $isAuthenticated,
            'username' => $isAuthenticated ? $this->session->getUsername() : null
        ]);
    }

    /**
     * Logout admin
     */
    public function logout(): void {
        $this->session->logout();               // Hapus session admin
        header('Location: /admin/login');       // Redirect ke halaman login
        exit;                                   // Hentikan eksekusi script
    }

    /**
     * Show aspiration management page
     */
    public function manageAspirations(): void {
        $this->session->requireAuth();  // Pastikan admin sudah login

        // Inisialisasi array filter dan parameter pagination
        $filters = [];                                    // Array untuk menyimpan filter pencarian
        $page = (int) ($_GET['page'] ?? 1);              // Halaman saat ini, default 1
        $limit = 10;                                     // Jumlah data per halaman (diubah dari 20 ke 10)
        $sortBy = $_GET['sort'] ?? 'created_at';         // Kolom untuk sorting, default created_at
        $sortOrder = $_GET['order'] ?? 'DESC';           // Urutan sorting, default DESC (terbaru dulu)

        // Terapkan filter pencarian jika ada
        if (!empty($_GET['search'])) {
            $filters['search'] = trim($_GET['search']);  // Filter pencarian teks
        }

        // Terapkan filter tanggal dan parameter lainnya
        if (!empty($_GET['date_from'])) {
            $filters['date_from'] = $_GET['date_from'];  // Filter tanggal mulai
        }
        if (!empty($_GET['date_to'])) {
            $filters['date_to'] = $_GET['date_to'];      // Filter tanggal akhir
        }
        if (!empty($_GET['month'])) {
            $filters['month'] = $_GET['month'];          // Filter berdasarkan bulan
        }
        if (!empty($_GET['nis'])) {
            $filters['nis'] = $_GET['nis'];              // Filter berdasarkan NIS siswa
        }
        if (!empty($_GET['id_kategori'])) {
            $filters['id_kategori'] = (int) $_GET['id_kategori'];  // Filter berdasarkan kategori
        }
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];        // Filter berdasarkan status aspirasi
        }

        // Ambil data aspirasi dengan filter dan pagination
        $aspirations = $this->aspirationModel->getFilteredList($filters, $page, $limit, $sortBy, $sortOrder);
        $totalCount = $this->aspirationModel->getFilteredCount($filters);  // Total data untuk pagination
        $totalPages = ceil($totalCount / $limit);                          // Hitung total halaman
        
        // Ambil data untuk dropdown filter
        $students = $this->studentModel->getAll();      // Semua data siswa untuk filter
        $categories = $this->categoryModel->getAll();   // Semua kategori untuk filter
        
        // Ambil username admin untuk display
        $username = $this->session->getUsername();

        include __DIR__ . '/../views/admin/manage_aspirations.php';  // Tampilkan halaman kelola aspirasi
    }

    /**
     * Update aspiration status via AJAX
     */
    public function updateStatus(): void {
        $this->session->requireAuth();  // Pastikan admin sudah login

        // Pastikan request method adalah POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Set HTTP status 405 Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        $id = (int) ($_POST['id'] ?? 0);      // Ambil ID aspirasi dari POST data
        $status = $_POST['status'] ?? '';     // Ambil status baru dari POST data

        // Validasi parameter input
        if ($id <= 0 || !in_array($status, ['Menunggu', 'Proses', 'Selesai'])) {
            http_response_code(400);  // Set HTTP status 400 Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        // Ambil username admin saat ini untuk audit trail
        $admin_username = $this->session->getUsername();

        // Update status aspirasi melalui model
        if ($this->aspirationModel->updateStatus($id, $status, $admin_username)) {
            echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);  // Return success JSON
        } else {
            http_response_code(500);  // Set HTTP status 500 Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);  // Return error JSON
        }
    }

    /**
     * Add feedback to aspiration via AJAX
     */
    public function addFeedback(): void {
        $this->session->requireAuth();  // Pastikan admin sudah login

        // Pastikan request method adalah POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Set HTTP status 405 Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        $id = (int) ($_POST['id'] ?? 0);        // Ambil ID aspirasi dari POST data
        $feedback = trim($_POST['feedback'] ?? '');  // Ambil feedback dari POST data dan trim whitespace

        // Validasi parameter input
        if ($id <= 0 || empty($feedback)) {
            http_response_code(400);  // Set HTTP status 400 Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        // Ambil username admin saat ini untuk audit trail
        $admin_username = $this->session->getUsername();

        // Tambah feedback melalui model
        if ($this->aspirationModel->addFeedback($id, $feedback, $admin_username)) {
            echo json_encode(['success' => true, 'message' => 'Feedback berhasil ditambahkan']);  // Return success JSON
        } else {
            http_response_code(500);  // Set HTTP status 500 Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan feedback']);  // Return error JSON
        }
    }

    /**
     * Delete aspiration via AJAX
     */
    public function deleteAspiration(): void {
        $this->session->requireAuth();  // Pastikan admin sudah login

        // Pastikan request method adalah POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Set HTTP status 405 Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        $id = (int) ($_POST['id'] ?? 0);      // Ambil ID aspirasi dari POST data

        // Validasi parameter input
        if ($id <= 0) {
            http_response_code(400);  // Set HTTP status 400 Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid aspiration ID']);  // Return error JSON
            return;  // Hentikan eksekusi
        }

        // Ambil username admin saat ini untuk audit trail
        $admin_username = $this->session->getUsername();

        // Hapus aspirasi melalui model
        if ($this->aspirationModel->deleteAspiration($id, $admin_username)) {
            echo json_encode(['success' => true, 'message' => 'Aspirasi berhasil dihapus']);  // Return success JSON
        } else {
            http_response_code(500);  // Set HTTP status 500 Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus aspirasi']);  // Return error JSON
        }
    }

    /**
     * View detailed aspiration with audit trail
     * 
     * Requirements: 6.5 - Display modification history in admin interface
     */
    public function viewAspirationDetail(): void {
        $this->session->requireAuth();

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /admin/aspirations');
            exit;
        }

        // Get aspiration details
        $aspiration = $this->aspirationModel->findById($id);
        if (!$aspiration) {
            $_SESSION['error_message'] = 'Aspirasi tidak ditemukan';
            header('Location: /admin/aspirations');
            exit;
        }

        // Get audit trail
        $auditTrail = $this->aspirationModel->getAuditTrail($aspiration['id_pelaporan']);

        include __DIR__ . '/../views/admin/aspiration_detail.php';
    }

    /**
     * Show category management page
     */
    public function manageCategories(): void {
        $this->session->requireAuth();
        
        $username = $this->session->getUsername();
        $message = $_SESSION['category_message'] ?? null;
        $error = $_SESSION['category_error'] ?? null;
        
        // Clear messages
        unset($_SESSION['category_message'], $_SESSION['category_error']);
        
        // Get categories for display
        $categories = $this->categoryModel->getAll();
        
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'add':
                    $this->handleAddCategoryPage();
                    break;
                case 'edit':
                    $this->handleEditCategoryPage();
                    break;
                case 'delete':
                    $this->handleDeleteCategoryPage();
                    break;
            }
            return;
        }
        
        include __DIR__ . '/../views/admin/manage_categories.php';
    }
    
    /**
     * Handle add category from manage categories page
     */
    private function handleAddCategoryPage(): void {
        $categoryName = trim($_POST['category_name'] ?? '');
        $categoryDescription = trim($_POST['category_description'] ?? '');
        
        if (empty($categoryName)) {
            $_SESSION['category_error'] = 'Nama kategori tidak boleh kosong';
            header('Location: /admin/categories');
            exit;
        }
        
        $data = [
            'ket_kategori' => $categoryName,
            'deskripsi' => $categoryDescription
        ];
        
        $errors = $this->categoryModel->validate($data);
        if (!empty($errors)) {
            $_SESSION['category_error'] = implode(', ', $errors);
            header('Location: /admin/categories');
            exit;
        }
        
        if ($this->categoryModel->create($data)) {
            $_SESSION['category_message'] = 'Kategori berhasil ditambahkan';
        } else {
            $_SESSION['category_error'] = 'Gagal menambahkan kategori';
        }
        
        header('Location: /admin/categories');
        exit;
    }
    
    /**
     * Handle edit category from manage categories page
     */
    private function handleEditCategoryPage(): void {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $categoryName = trim($_POST['category_name'] ?? '');
        $categoryDescription = trim($_POST['category_description'] ?? '');
        
        if ($categoryId <= 0 || empty($categoryName)) {
            $_SESSION['category_error'] = 'Data kategori tidak valid';
            header('Location: /admin/categories');
            exit;
        }
        
        $data = [
            'id_kategori' => $categoryId,
            'ket_kategori' => $categoryName,
            'deskripsi' => $categoryDescription
        ];
        
        $errors = $this->categoryModel->validate($data);
        if (!empty($errors)) {
            $_SESSION['category_error'] = implode(', ', $errors);
            header('Location: /admin/categories');
            exit;
        }
        
        if ($this->categoryModel->update($categoryId, [
            'ket_kategori' => $categoryName,
            'deskripsi' => $categoryDescription
        ])) {
            $_SESSION['category_message'] = 'Kategori berhasil diperbarui';
        } else {
            $_SESSION['category_error'] = 'Gagal memperbarui kategori';
        }
        
        header('Location: /admin/categories');
        exit;
    }
    
    /**
     * Handle delete category from manage categories page
     */
    private function handleDeleteCategoryPage(): void {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        
        if ($categoryId <= 0) {
            $_SESSION['category_error'] = 'ID kategori tidak valid';
            header('Location: /admin/categories');
            exit;
        }
        
        // Check if category is referenced by aspirations
        if ($this->categoryModel->isReferencedByAspirations($categoryId)) {
            $_SESSION['category_error'] = 'Kategori tidak dapat dihapus karena masih digunakan oleh aspirasi';
            header('Location: /admin/categories');
            exit;
        }
        
        if ($this->categoryModel->delete($categoryId)) {
            $_SESSION['category_message'] = 'Kategori berhasil dihapus';
        } else {
            $_SESSION['category_error'] = 'Gagal menghapus kategori';
        }
        
        header('Location: /admin/categories');
        exit;
    }
    
    /**
     * Get category detail via AJAX
     */
    public function getCategoryDetail(): void {
        $this->session->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $categoryId = (int) ($_GET['id'] ?? 0);
        
        if ($categoryId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            return;
        }
        
        try {
            error_log("Getting category detail for ID: " . $categoryId);
            
            // Get category details
            $category = $this->categoryModel->findById($categoryId);
            if (!$category) {
                error_log("Category not found for ID: " . $categoryId);
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Category not found']);
                return;
            }
            
            error_log("Category found: " . json_encode($category));
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'category' => $category
                ]
            ]);
        } catch (Exception $e) {
            error_log("Error in getCategoryDetail: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Show location management page
     */
    public function manageLocations(): void {
        $this->session->requireAuth();
        
        $username = $this->session->getUsername();
        $message = $_SESSION['location_message'] ?? null;
        $error = $_SESSION['location_error'] ?? null;
        
        // Clear messages
        unset($_SESSION['location_message'], $_SESSION['location_error']);
        
        // Get locations for display
        $locations = $this->locationModel->getAll();
        
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'add':
                    $this->handleAddLocationPage();
                    break;
                case 'edit':
                    $this->handleEditLocationPage();
                    break;
                case 'delete':
                    $this->handleDeleteLocationPage();
                    break;
            }
            return;
        }
        
        include __DIR__ . '/../views/admin/manage_locations.php';
    }
    
    /**
     * Handle add location from manage locations page
     */
    private function handleAddLocationPage(): void {
        $locationName = trim($_POST['location_name'] ?? '');
        $locationDescription = trim($_POST['location_description'] ?? '');
        
        if (empty($locationName)) {
            $_SESSION['location_error'] = 'Nama lokasi tidak boleh kosong';
            header('Location: /admin/locations');
            exit;
        }
        
        $data = [
            'nama_lokasi' => $locationName,
            'deskripsi' => $locationDescription
        ];
        
        $errors = $this->locationModel->validate($data);
        if (!empty($errors)) {
            $_SESSION['location_error'] = implode(', ', $errors);
            header('Location: /admin/locations');
            exit;
        }
        
        if ($this->locationModel->create($data)) {
            $_SESSION['location_message'] = 'Lokasi berhasil ditambahkan';
        } else {
            $_SESSION['location_error'] = 'Gagal menambahkan lokasi';
        }
        
        header('Location: /admin/locations');
        exit;
    }
    
    /**
     * Handle edit location from manage locations page
     */
    private function handleEditLocationPage(): void {
        $locationId = (int) ($_POST['location_id'] ?? 0);
        $locationName = trim($_POST['location_name'] ?? '');
        $locationDescription = trim($_POST['location_description'] ?? '');
        
        if ($locationId <= 0 || empty($locationName)) {
            $_SESSION['location_error'] = 'Data lokasi tidak valid';
            header('Location: /admin/locations');
            exit;
        }
        
        $data = [
            'id_lokasi' => $locationId,
            'nama_lokasi' => $locationName,
            'deskripsi' => $locationDescription
        ];
        
        $errors = $this->locationModel->validate($data);
        if (!empty($errors)) {
            $_SESSION['location_error'] = implode(', ', $errors);
            header('Location: /admin/locations');
            exit;
        }
        
        if ($this->locationModel->update($locationId, [
            'nama_lokasi' => $locationName,
            'deskripsi' => $locationDescription
        ])) {
            $_SESSION['location_message'] = 'Lokasi berhasil diperbarui';
        } else {
            $_SESSION['location_error'] = 'Gagal memperbarui lokasi';
        }
        
        header('Location: /admin/locations');
        exit;
    }
    
    /**
     * Handle delete location from manage locations page
     */
    private function handleDeleteLocationPage(): void {
        $locationId = (int) ($_POST['location_id'] ?? 0);
        
        if ($locationId <= 0) {
            $_SESSION['location_error'] = 'ID lokasi tidak valid';
            header('Location: /admin/locations');
            exit;
        }
        
        // Check if location is referenced by aspirations
        if ($this->locationModel->isReferencedByAspirations($locationId)) {
            $_SESSION['location_error'] = 'Lokasi tidak dapat dihapus karena masih digunakan oleh aspirasi';
            header('Location: /admin/locations');
            exit;
        }
        
        if ($this->locationModel->delete($locationId)) {
            $_SESSION['location_message'] = 'Lokasi berhasil dihapus';
        } else {
            $_SESSION['location_error'] = 'Gagal menghapus lokasi';
        }
        
        header('Location: /admin/locations');
        exit;
    }
    
    /**
     * Get location detail via AJAX
     */
    public function getLocationDetail(): void {
        $this->session->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $locationId = (int) ($_GET['id'] ?? 0);
        
        if ($locationId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid location ID']);
            return;
        }
        
        try {
            error_log("Getting location detail for ID: " . $locationId);
            
            // Get location details
            $location = $this->locationModel->findById($locationId);
            if (!$location) {
                error_log("Location not found for ID: " . $locationId);
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Location not found']);
                return;
            }
            
            error_log("Location found: " . json_encode($location));
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'location' => $location
                ]
            ]);
        } catch (Exception $e) {
            error_log("Error in getLocationDetail: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    public function showSettings(): void {
        $this->session->requireAuth();
        
        $username = $this->session->getUsername();
        $message = $_SESSION['settings_message'] ?? null;
        $error = $_SESSION['settings_error'] ?? null;
        
        // Clear messages
        unset($_SESSION['settings_message'], $_SESSION['settings_error']);
        
        // Get categories and locations for display
        $categories = $this->categoryModel->getAll();
        $locations = $this->locationModel->getAll();
        
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'change_password':
                    $this->handlePasswordChange();
                    break;
                case 'add_category':
                    $this->handleAddCategory();
                    break;
                case 'edit_category':
                    $this->handleEditCategory();
                    break;
                case 'delete_category':
                    $this->handleDeleteCategory();
                    break;
                case 'add_location':
                    $this->handleAddLocation();
                    break;
                case 'edit_location':
                    $this->handleEditLocation();
                    break;
                case 'delete_location':
                    $this->handleDeleteLocation();
                    break;
            }
            return;
        }
        
        include __DIR__ . '/../views/admin/settings.php';
    }
    
    /**
     * Show reports page
     */
    public function showReports(): void {
        $this->session->requireAuth();
        
        $username = $this->session->getUsername();
        
        // Get filter parameters
        $filters = [];
        
        // Handle different filter types
        $filterType = $_GET['filter_type'] ?? '';
        
        if ($filterType === 'daily' && !empty($_GET['daily_date'])) {
            // Daily filter - set both date_from and date_to to the same date
            $filters['date_from'] = $_GET['daily_date'];
            $filters['date_to'] = $_GET['daily_date'];
            $filters['filter_type'] = 'daily';
        } elseif ($filterType === 'monthly' && !empty($_GET['monthly_date'])) {
            // Monthly filter - set date range for the entire month
            $monthYear = $_GET['monthly_date']; // Format: YYYY-MM
            $filters['date_from'] = $monthYear . '-01';
            $filters['date_to'] = date('Y-m-t', strtotime($monthYear . '-01')); // Last day of month
            $filters['filter_type'] = 'monthly';
            $filters['month'] = $monthYear;
        } elseif ($filterType === 'range') {
            // Range filter - use date_from and date_to
            if (!empty($_GET['date_from'])) {
                $filters['date_from'] = $_GET['date_from'];
            }
            if (!empty($_GET['date_to'])) {
                $filters['date_to'] = $_GET['date_to'];
            }
            $filters['filter_type'] = 'range';
        } else {
            // Legacy support for old filter parameters
            if (!empty($_GET['date_from'])) {
                $filters['date_from'] = $_GET['date_from'];
            }
            if (!empty($_GET['date_to'])) {
                $filters['date_to'] = $_GET['date_to'];
            }
            if (!empty($_GET['month'])) {
                $filters['month'] = $_GET['month'];
            }
        }
        
        // Other filters
        if (!empty($_GET['id_kategori'])) {
            $filters['id_kategori'] = (int) $_GET['id_kategori'];
        }
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        
        // Get report data with error handling
        try {
            $reportData = $this->aspirationModel->getReportData($filters);
            
            // Ensure reportData has required keys
            if (!isset($reportData['details'])) {
                $reportData['details'] = [];
            }
            if (!isset($reportData['summary'])) {
                $reportData['summary'] = [
                    'total' => 0,
                    'menunggu' => 0,
                    'proses' => 0,
                    'selesai' => 0
                ];
            }
            if (!isset($reportData['categoryBreakdown'])) {
                $reportData['categoryBreakdown'] = [];
            }
        } catch (Exception $e) {
            // Handle database errors gracefully
            $reportData = [
                'details' => [],
                'summary' => [
                    'total' => 0,
                    'menunggu' => 0,
                    'proses' => 0,
                    'selesai' => 0
                ],
                'categoryBreakdown' => [],
                'filters' => $filters
            ];
            error_log("Error in showReports: " . $e->getMessage());
        }
        
        $categories = $this->categoryModel->getAll();
        
        include __DIR__ . '/../views/admin/reports.php';
    }

    /**
     * Export report to PDF
     */
    public function exportReportToPDF(): void {
        $this->session->requireAuth();
        
        // Get filter parameters from POST or GET
        $filters = [];
        $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
        
        // Handle different filter types
        $filterType = $source['filter_type'] ?? '';
        
        if ($filterType === 'daily' && !empty($source['daily_date'])) {
            // Daily filter - set both date_from and date_to to the same date
            $filters['date_from'] = $source['daily_date'];
            $filters['date_to'] = $source['daily_date'];
            $filters['filter_type'] = 'daily';
        } elseif ($filterType === 'monthly' && !empty($source['monthly_date'])) {
            // Monthly filter - set date range for the entire month
            $monthYear = $source['monthly_date']; // Format: YYYY-MM
            $filters['date_from'] = $monthYear . '-01';
            $filters['date_to'] = date('Y-m-t', strtotime($monthYear . '-01')); // Last day of month
            $filters['filter_type'] = 'monthly';
            $filters['month'] = $monthYear;
        } elseif ($filterType === 'range') {
            // Range filter - use date_from and date_to
            if (!empty($source['date_from'])) {
                $filters['date_from'] = $source['date_from'];
            }
            if (!empty($source['date_to'])) {
                $filters['date_to'] = $source['date_to'];
            }
            $filters['filter_type'] = 'range';
        } else {
            // Legacy support for old filter parameters
            if (!empty($source['date_from'])) {
                $filters['date_from'] = $source['date_from'];
            }
            if (!empty($source['date_to'])) {
                $filters['date_to'] = $source['date_to'];
            }
            if (!empty($source['month'])) {
                $filters['month'] = $source['month'];
            }
        }
        
        // Other filters
        if (!empty($source['id_kategori'])) {
            $filters['id_kategori'] = (int) $source['id_kategori'];
        }
        if (!empty($source['status'])) {
            $filters['status'] = $source['status'];
        }
        
        try {
            // Get report data
            $reportData = $this->aspirationModel->getReportData($filters);
            
            // Ensure reportData has required keys
            if (!isset($reportData['details'])) {
                $reportData['details'] = [];
            }
            if (!isset($reportData['summary'])) {
                $reportData['summary'] = [
                    'total' => 0,
                    'menunggu' => 0,
                    'proses' => 0,
                    'selesai' => 0
                ];
            }
            
            // Check if DomPDF is available
            $autoloadPath = __DIR__ . '/../vendor/autoload.php';
            if (file_exists($autoloadPath)) {
                require_once $autoloadPath;
                
                if (class_exists('Dompdf\Dompdf')) {
                    // Use DomPDF if available
                    $this->generatePDFWithDomPDF($reportData, $filters);
                    return;
                }
            }
            
            // Fallback: Generate HTML for print/save as PDF
            $this->generatePrintableHTML($reportData, $filters);
            
        } catch (Exception $e) {
            error_log("Error generating PDF: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal menghasilkan PDF: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Generate PDF using DomPDF library
     */
    private function generatePDFWithDomPDF(array $reportData, array $filters): void {
        // Generate filename
        $filename = 'Laporan_Aspirasi_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Generate PDF content
        ob_start();
        include __DIR__ . '/../views/admin/pdf_report_template.php';
        $html = ob_get_clean();
        
        // Create PDF
        $dompdf = new \Dompdf\Dompdf([
            'enable_remote' => false,
            'enable_php' => false,
            'enable_html5_parser' => true,
            'default_font' => 'DejaVu Sans'
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        
        // Set margins to 3cm on all sides
        $dompdf->getCanvas()->get_cpdf()->addInfo('Margin', '3cm');
        $dompdf->render();
        
        // Output PDF for download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        echo $dompdf->output();
        exit;
    }
    
    /**
     * Generate printable HTML as fallback
     */
    private function generatePrintableHTML(array $reportData, array $filters): void {
        // Generate filename
        $filename = 'Laporan_Aspirasi_' . date('Y-m-d_H-i-s') . '.html';
        
        // Generate HTML content
        ob_start();
        include __DIR__ . '/../views/admin/pdf_report_template.php';
        $html = ob_get_clean();
        
        // Add print styles and auto-print script
        $printScript = '
        <script>
            window.onload = function() {
                window.print();
            };
        </script>
        <style>
            @media print {
                body { margin: 0; }
                .no-print { display: none; }
            }
        </style>';
        
        $html = str_replace('</head>', $printScript . '</head>', $html);
        
        // Output HTML for printing
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        
        echo $html;
        exit;
    }

    /**
     * Handle password change
     */
    private function handlePasswordChange(): void {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate inputs
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['settings_error'] = 'Semua field password harus diisi';
            header('Location: /admin/settings');
            exit;
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['settings_error'] = 'Password baru dan konfirmasi tidak cocok';
            header('Location: /admin/settings');
            exit;
        }
        
        if (strlen($newPassword) < 6) {
            $_SESSION['settings_error'] = 'Password baru minimal 6 karakter';
            header('Location: /admin/settings');
            exit;
        }
        
        $username = $this->session->getUsername();
        
        // Verify current password
        if (!$this->adminModel->authenticate($username, $currentPassword)) {
            $_SESSION['settings_error'] = 'Password saat ini salah';
            header('Location: /admin/settings');
            exit;
        }
        
        // Update password
        if ($this->adminModel->updatePassword($username, $newPassword)) {
            $_SESSION['settings_message'] = 'Password berhasil diubah';
        } else {
            $_SESSION['settings_error'] = 'Gagal mengubah password';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle add category
     */
    private function handleAddCategory(): void {
        $categoryName = trim($_POST['category_name'] ?? '');
        
        if (empty($categoryName)) {
            $_SESSION['settings_error'] = 'Nama kategori tidak boleh kosong';
            header('Location: /admin/settings');
            exit;
        }
        
        $errors = $this->categoryModel->validate(['ket_kategori' => $categoryName]);
        if (!empty($errors)) {
            $_SESSION['settings_error'] = implode(', ', $errors);
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->categoryModel->create(['ket_kategori' => $categoryName])) {
            $_SESSION['settings_message'] = 'Kategori berhasil ditambahkan';
        } else {
            $_SESSION['settings_error'] = 'Gagal menambahkan kategori';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle edit category
     */
    private function handleEditCategory(): void {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $categoryName = trim($_POST['category_name'] ?? '');
        
        if ($categoryId <= 0 || empty($categoryName)) {
            $_SESSION['settings_error'] = 'Data kategori tidak valid';
            header('Location: /admin/settings');
            exit;
        }
        
        $errors = $this->categoryModel->validate([
            'id_kategori' => $categoryId,
            'ket_kategori' => $categoryName
        ]);
        if (!empty($errors)) {
            $_SESSION['settings_error'] = implode(', ', $errors);
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->categoryModel->update($categoryId, ['ket_kategori' => $categoryName])) {
            $_SESSION['settings_message'] = 'Kategori berhasil diperbarui';
        } else {
            $_SESSION['settings_error'] = 'Gagal memperbarui kategori';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle delete category
     */
    private function handleDeleteCategory(): void {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        
        if ($categoryId <= 0) {
            $_SESSION['settings_error'] = 'ID kategori tidak valid';
            header('Location: /admin/settings');
            exit;
        }
        
        // Check if category is referenced by aspirations
        if ($this->categoryModel->isReferencedByAspirations($categoryId)) {
            $_SESSION['settings_error'] = 'Kategori tidak dapat dihapus karena masih digunakan oleh aspirasi';
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->categoryModel->delete($categoryId)) {
            $_SESSION['settings_message'] = 'Kategori berhasil dihapus';
        } else {
            $_SESSION['settings_error'] = 'Gagal menghapus kategori';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle add location
     */
    private function handleAddLocation(): void {
        $locationName = trim($_POST['location_name'] ?? '');
        
        if (empty($locationName)) {
            $_SESSION['settings_error'] = 'Nama lokasi tidak boleh kosong';
            header('Location: /admin/settings');
            exit;
        }
        
        $errors = $this->locationModel->validate(['nama_lokasi' => $locationName]);
        if (!empty($errors)) {
            $_SESSION['settings_error'] = implode(', ', $errors);
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->locationModel->create(['nama_lokasi' => $locationName])) {
            $_SESSION['settings_message'] = 'Lokasi berhasil ditambahkan';
        } else {
            $_SESSION['settings_error'] = 'Gagal menambahkan lokasi';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle edit location
     */
    private function handleEditLocation(): void {
        $locationId = (int) ($_POST['location_id'] ?? 0);
        $locationName = trim($_POST['location_name'] ?? '');
        
        if ($locationId <= 0 || empty($locationName)) {
            $_SESSION['settings_error'] = 'Data lokasi tidak valid';
            header('Location: /admin/settings');
            exit;
        }
        
        $errors = $this->locationModel->validate([
            'id_lokasi' => $locationId,
            'nama_lokasi' => $locationName
        ]);
        if (!empty($errors)) {
            $_SESSION['settings_error'] = implode(', ', $errors);
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->locationModel->update($locationId, ['nama_lokasi' => $locationName])) {
            $_SESSION['settings_message'] = 'Lokasi berhasil diperbarui';
        } else {
            $_SESSION['settings_error'] = 'Gagal memperbarui lokasi';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Handle delete location
     */
    private function handleDeleteLocation(): void {
        $locationId = (int) ($_POST['location_id'] ?? 0);
        
        if ($locationId <= 0) {
            $_SESSION['settings_error'] = 'ID lokasi tidak valid';
            header('Location: /admin/settings');
            exit;
        }
        
        // Check if location is referenced by aspirations
        if ($this->locationModel->isReferencedByAspirations($locationId)) {
            $_SESSION['settings_error'] = 'Lokasi tidak dapat dihapus karena masih digunakan oleh aspirasi';
            header('Location: /admin/settings');
            exit;
        }
        
        if ($this->locationModel->delete($locationId)) {
            $_SESSION['settings_message'] = 'Lokasi berhasil dihapus';
        } else {
            $_SESSION['settings_error'] = 'Gagal menghapus lokasi';
        }
        
        header('Location: /admin/settings');
        exit;
    }
    
    /**
     * Export report to Excel
     */
    public function exportReportToExcel(): void {
        $this->session->requireAuth();
        
        // Get filter parameters from POST or GET
        $filters = [];
        $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
        
        if (!empty($source['date_from'])) {
            $filters['date_from'] = $source['date_from'];
        }
        if (!empty($source['date_to'])) {
            $filters['date_to'] = $source['date_to'];
        }
        if (!empty($source['month'])) {
            $filters['month'] = $source['month'];
        }
        if (!empty($source['id_kategori'])) {
            $filters['id_kategori'] = (int) $source['id_kategori'];
        }
        if (!empty($source['status'])) {
            $filters['status'] = $source['status'];
        }
        
        try {
            // Get report data
            $reportData = $this->aspirationModel->getReportData($filters);
            
            // Ensure reportData has required keys
            if (!isset($reportData['details'])) {
                $reportData['details'] = [];
            }
            if (!isset($reportData['summary'])) {
                $reportData['summary'] = [
                    'total' => 0,
                    'menunggu' => 0,
                    'proses' => 0,
                    'selesai' => 0
                ];
            }
            
            // Generate filename
            $filename = 'Laporan_Aspirasi_Siswa_' . date('Y-m-d_H-i-s') . '.xls';
            
            // Generate Excel content
            ob_start();
            include __DIR__ . '/../views/admin/excel_report_template.php';
            $html = ob_get_clean();
            
            // Output Excel for download
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            // Add BOM for UTF-8 support in Excel
            echo "\xEF\xBB\xBF";
            echo $html;
            exit;
            
        } catch (Exception $e) {
            error_log("Error generating Excel: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal menghasilkan Excel: ' . $e->getMessage()]);
        }
    }
}