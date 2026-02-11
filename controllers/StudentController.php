<?php

require_once __DIR__ . '/../models/Student.php';    // Import model Student untuk operasi data siswa
require_once __DIR__ . '/../models/Aspiration.php'; // Import model Aspiration untuk operasi aspirasi
require_once __DIR__ . '/../models/Category.php';   // Import model Category untuk data kategori
require_once __DIR__ . '/../models/Location.php';   // Import model Location untuk data lokasi

/**
 * Student Controller
 * 
 * Handles student aspiration submission and viewing functions
 * Requirements: 1.1, 1.4, 4.1, 4.2, 4.4
 */
class StudentController {
    private $studentModel;     // Instance model Student untuk operasi data siswa
    private $aspirationModel;  // Instance model Aspiration untuk operasi aspirasi
    private $categoryModel;    // Instance model Category untuk data kategori
    private $locationModel;    // Instance model Location untuk data lokasi

    public function __construct() {
        $this->studentModel = new Student();       // Inisialisasi model Student
        $this->aspirationModel = new Aspiration(); // Inisialisasi model Aspiration
        $this->categoryModel = new Category();     // Inisialisasi model Category
        $this->locationModel = new Location();     // Inisialisasi model Location
    }

    /**
     * Show integrated student portal with all features in one page
     * 
     * Requirements: 8.1 - Provide clear navigation between student sections
     */
    public function showIntegratedPortal() {
        // Ambil data kategori dan lokasi untuk dropdown form
        $categories = $this->categoryModel->getAll();  // Semua kategori untuk pilihan dropdown
        $locations = $this->locationModel->getAll();   // Semua lokasi untuk pilihan dropdown
        
        // Ambil pesan dari session jika ada (success/error dari form submission)
        $error = $_SESSION['form_error'] ?? null;      // Pesan error jika ada
        $success = $_SESSION['form_success'] ?? null;  // Pesan sukses jika ada
        $oldInput = $_SESSION['old_input'] ?? [];      // Data input lama untuk repopulate form
        
        // Hapus pesan dari session setelah diambil
        unset($_SESSION['form_error'], $_SESSION['form_success'], $_SESSION['old_input']);
        
        // Tampilkan halaman portal terintegrasi dengan variabel yang sudah disiapkan
        include __DIR__ . '/../views/student/portal-integrated.php';
    }

    /**
     * Show student portal landing page
     * 
     * Requirements: 8.1 - Provide clear navigation between student sections
     */
    public function showPortal() {
        // Tampilkan halaman landing portal siswa
        include __DIR__ . '/../views/student/portal.php';
    }

    /**
     * Show aspiration submission form
     * 
     * Requirements: 1.1 - Provide form for students to submit facility aspirations
     */
    public function showAspirationForm() {
        // Get categories and locations for dropdown
        $categories = $this->categoryModel->getAll();
        $locations = $this->locationModel->getAll();
        
        // Get any error or success messages from session
        $error = $_SESSION['form_error'] ?? null;
        $success = $_SESSION['form_success'] ?? null;
        $oldInput = $_SESSION['old_input'] ?? [];
        
        // Clear session messages
        unset($_SESSION['form_error'], $_SESSION['form_success'], $_SESSION['old_input']);
        
        include __DIR__ . '/../views/student/aspiration_form.php';
    }

    /**
     * Submit aspiration with validation and error handling
     * 
     * Requirements: 1.4 - Save aspiration with unique ID and timestamp
     * Requirements: 1.6 - Validate all required fields before submission
     * Requirements: 1.7 - Display validation errors and prevent submission
     */
    public function submitAspiration() {
        // Enable error logging
        error_log("=== Submit Aspiration Started ===");
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Not a POST request, redirecting");
            header('Location: /student/aspiration');
            exit;
        }

        // Get form data - convert NIS to integer as per ERD
        $nis = (int) trim($_POST['nis'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $id_kategori = (int) ($_POST['id_kategori'] ?? 0);
        $id_lokasi = (int) ($_POST['id_lokasi'] ?? 0);
        $ket = trim($_POST['ket'] ?? '');

        error_log("Form data received: NIS=$nis, Kelas=$kelas, Kategori=$id_kategori, Lokasi=$id_lokasi");

        // Store old input for repopulation
        $_SESSION['old_input'] = [
            'nis' => $nis,
            'kelas' => $kelas,
            'id_kategori' => $id_kategori,
            'id_lokasi' => $id_lokasi,
            'ket' => $ket
        ];

        // Validate input
        $errors = $this->validateAspirationInput([
            'nis' => $nis,
            'kelas' => $kelas,
            'id_kategori' => $id_kategori,
            'id_lokasi' => $id_lokasi,
            'ket' => $ket
        ]);

        if (!empty($errors)) {
            error_log("Validation errors: " . implode(', ', $errors));
            $_SESSION['form_error'] = implode('<br>', $errors);
            header('Location: /student/aspiration');
            exit;
        }

        try {
            // Check if student exists, if not create
            $student = $this->studentModel->findByNis($nis);
            if (!$student) {
                error_log("Student not found, creating new student");
                $studentCreated = $this->studentModel->create([
                    'nis' => $nis,
                    'kelas' => $kelas
                ]);
                
                if (!$studentCreated) {
                    error_log("Failed to create student");
                    $_SESSION['form_error'] = 'Gagal menyimpan data siswa';
                    header('Location: /student/aspiration');
                    exit;
                }
                error_log("Student created successfully");
            } else {
                error_log("Student already exists with NIS: $nis, Class: " . $student['kelas']);
                // Update student class if different (student might have moved to different class)
                if ($student['kelas'] !== $kelas) {
                    error_log("Updating student class from {$student['kelas']} to $kelas");
                    // Note: We don't update here to avoid overwriting data, just log the difference
                }
            }

            // Generate unique id_pelaporan - let the model handle uniqueness
            // Remove the manual generation to avoid conflicts
            // $id_pelaporan = $this->generateReportId();
            // error_log("Generated ID Pelaporan: $id_pelaporan");

            // Create aspiration - let the model generate unique ID
            $aspirationData = [
                // Remove id_pelaporan from here, let model generate it
                'nis' => $nis,
                'id_kategori' => $id_kategori,
                'id_lokasi' => $id_lokasi,
                'ket' => $ket,
                'status' => 'Menunggu' // Requirement 1.5 - Initial status is "Menunggu"
            ];

            error_log("Creating aspiration with data: " . json_encode($aspirationData));

            $id_pelaporan = $this->aspirationModel->create($aspirationData);
            if ($id_pelaporan) {
                error_log("Aspiration created successfully with ID: $id_pelaporan");
                unset($_SESSION['old_input']);
                $_SESSION['form_success'] = 'Aspirasi berhasil dikirim! ID Pelaporan: ' . $id_pelaporan;
                header('Location: /student/aspiration');
                exit;
            } else {
                error_log("Failed to create aspiration");
                $_SESSION['form_error'] = 'Gagal menyimpan aspirasi. Silakan coba lagi.';
                header('Location: /student/aspiration');
                exit;
            }
        } catch (Exception $e) {
            error_log("Exception occurred: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $_SESSION['form_error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            header('Location: /student/aspiration');
            exit;
        }
    }

    /**
     * Show status and progress for student's aspirations (combined feedback and progress)
     * 
     * Requirements: 4.1 - Provide page for students to view feedback
     * Requirements: 4.2 - Display current status with visual indicators
     * Requirements: 4.3 - Show feedback comments from admin when available
     * Requirements: 4.5 - Allow students to view progress of facility improvements
     */
    public function showFeedback() {
        // Get NIS from query parameter
        $nis = trim($_GET['nis'] ?? '');

        if (empty($nis)) {
            $error = 'NIS harus diisi untuk melihat status & progress';
            include __DIR__ . '/../views/student/feedback.php';
            return;
        }

        // Convert NIS to integer as per ERD
        $nis = (int) $nis;
        if ($nis <= 0) {
            $error = 'NIS harus berupa angka yang valid';
            include __DIR__ . '/../views/student/feedback.php';
            return;
        }

        try {
            // Get student's aspirations with feedback and progress
            $aspirations = $this->aspirationModel->findByStudent($nis);
            
            error_log("Controller: Got " . count($aspirations) . " aspirations");
            foreach($aspirations as $index => $asp) {
                error_log("  Controller [$index]: ID " . $asp['id_pelaporan'] . " - Ket: " . $asp['ket']);
            }
            
            // Get audit trail for each aspiration to show progress timeline
            foreach ($aspirations as &$aspiration) {
                $aspiration['audit_trail'] = $this->aspirationModel->getAuditTrail($aspiration['id_pelaporan']);
            }
            
            if (empty($aspirations)) {
                $error = 'Tidak ditemukan aspirasi untuk NIS tersebut';
            }
            
        } catch (Exception $e) {
            error_log("Error fetching status & progress: " . $e->getMessage());
            $error = 'Terjadi kesalahan saat mengambil data status & progress';
        }
        
        include __DIR__ . '/../views/student/feedback.php';
    }

    /**
     * View aspiration history for a student
     * 
     * Requirements: 4.4 - Display complete history including submission date and status changes
     * Requirements: 4.6 - Show aspirations sorted by submission date
     */
    public function viewHistory() {
        // Get NIS from query parameter
        $nis = trim($_GET['nis'] ?? '');

        if (empty($nis)) {
            $error = 'NIS harus diisi untuk melihat histori';
            include __DIR__ . '/../views/student/history.php';
            return;
        }

        // Convert NIS to integer as per ERD
        $nis = (int) $nis;
        if ($nis <= 0) {
            $error = 'NIS harus berupa angka yang valid';
            include __DIR__ . '/../views/student/history.php';
            return;
        }

        try {
            // Get student's aspirations sorted by submission date (newest first)
            $aspirations = $this->aspirationModel->findByStudent($nis);
            
            if (empty($aspirations)) {
                $error = 'Tidak ditemukan histori aspirasi untuk NIS tersebut';
            }
            
        } catch (Exception $e) {
            error_log("Error fetching history: " . $e->getMessage());
            $error = 'Terjadi kesalahan saat mengambil data histori';
        }
        
        include __DIR__ . '/../views/student/history.php';
    }

    /**
     * Validate aspiration input data
     * 
     * Requirements: 1.2 - Require student information (NIS, name, class)
     * Requirements: 1.3 - Require complaint details (category, location, description)
     * Requirements: 1.6 - Validate all required fields
     */
    private function validateAspirationInput(array $data): array {
        $errors = [];

        // Validate NIS (required, integer, max 10 digits)
        if (empty($data['nis']) || $data['nis'] <= 0) {
            $errors[] = 'NIS harus diisi dengan angka yang valid';
        } elseif (strlen((string)$data['nis']) > 10) {
            $errors[] = 'NIS maksimal 10 digit';
        }

        // Validate kelas (required, max 10 characters)
        if (empty($data['kelas'])) {
            $errors[] = 'Kelas harus diisi';
        } elseif (strlen($data['kelas']) > 10) {
            $errors[] = 'Kelas maksimal 10 karakter';
        }

        // Validate category (required, must be valid ID)
        if (empty($data['id_kategori']) || $data['id_kategori'] <= 0) {
            $errors[] = 'Kategori harus dipilih';
        } else {
            // Check if category exists
            $category = $this->categoryModel->findById($data['id_kategori']);
            if (!$category) {
                $errors[] = 'Kategori tidak valid';
            }
        }

        // Validate location (required, must be valid ID)
        if (empty($data['id_lokasi']) || $data['id_lokasi'] <= 0) {
            $errors[] = 'Lokasi harus dipilih';
        } else {
            // Check if location exists
            $location = $this->locationModel->findById($data['id_lokasi']);
            if (!$location) {
                $errors[] = 'Lokasi tidak valid';
            }
        }

        // Validate ket/description (required, max 50 characters, no HTML tags)
        if (empty($data['ket'])) {
            $errors[] = 'Keterangan harus diisi';
        } elseif (strlen($data['ket']) > 50) {
            $errors[] = 'Keterangan maksimal 50 karakter';
        } elseif ($data['ket'] !== strip_tags($data['ket'])) {
            $errors[] = 'Keterangan tidak boleh mengandung HTML tags';
        }

        return $errors;
    }

    /**
     * Generate unique 5-digit random report ID
     */
    private function generateReportId(): int {
        $maxAttempts = 10;
        $attempts = 0;
        
        do {
            // Generate random 5-digit number (10000-99999)
            $id = rand(10000, 99999);
            
            // Check if ID already exists
            $existing = $this->aspirationModel->findByReportId($id);
            $attempts++;
            
            // If unique ID found or max attempts reached, break
            if (!$existing || $attempts >= $maxAttempts) {
                break;
            }
        } while ($attempts < $maxAttempts);
        
        return $id;
    }

    /**
     * API endpoint to get status and progress data as JSON (combined feedback and progress)
     */
    public function getFeedbackAPI() {
        header('Content-Type: application/json');
        
        $nis = (int) ($_GET['nis'] ?? 0);
        
        if ($nis <= 0) {
            echo json_encode(['error' => 'NIS harus berupa angka yang valid']);
            return;
        }

        try {
            $aspirations = $this->aspirationModel->findByStudent($nis);
            
            // Get audit trail for each aspiration
            foreach ($aspirations as &$aspiration) {
                $aspiration['audit_trail'] = $this->aspirationModel->getAuditTrail($aspiration['id_pelaporan']);
            }
            
            if (empty($aspirations)) {
                echo json_encode(['error' => 'Tidak ditemukan aspirasi untuk NIS tersebut']);
                return;
            }
            
            echo json_encode(['success' => true, 'data' => $aspirations]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data']);
        }
    }

    /**
     * API endpoint to get history data as JSON
     */
    public function getHistoryAPI() {
        header('Content-Type: application/json');
        
        $nis = (int) ($_GET['nis'] ?? 0);
        
        if ($nis <= 0) {
            echo json_encode(['error' => 'NIS harus berupa angka yang valid']);
            return;
        }

        try {
            $aspirations = $this->aspirationModel->findByStudent($nis);
            
            if (empty($aspirations)) {
                echo json_encode(['error' => 'Tidak ditemukan histori aspirasi untuk NIS tersebut']);
                return;
            }
            
            echo json_encode(['success' => true, 'data' => $aspirations]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data']);
        }
    }

}