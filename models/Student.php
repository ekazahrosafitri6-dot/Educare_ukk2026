<?php

require_once __DIR__ . '/Database.php';

/**
 * Student Model
 * 
 * Handles student data operations
 * Requirements: 1.2, 7.2
 */
class Student {
    private $db;
    private $nis = null;
    private $kelas = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new student record
     * 
     * @param array $data Student data containing 'nis' and 'kelas'
     * @return bool True if student created successfully, false otherwise
     * 
     * Requirements: 1.2 - Student information (NIS, class) must be captured
     * Requirements: 7.2 - Maintain referential integrity
     */
    public function create($data) {
        // Validate data before creating
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return false;
        }

        // Check if student already exists to prevent duplicates
        $existing = $this->findByNis($data['nis']);
        if ($existing) {
            error_log("Student with NIS {$data['nis']} already exists, skipping creation");
            // Set instance properties from existing data
            $this->nis = $existing['nis'];
            $this->kelas = $existing['kelas'];
            return true; // Return true since student exists (not an error)
        }

        $sql = "INSERT INTO siswa (nis, kelas) VALUES (:nis, :kelas)";
        
        try {
            $this->db->execute($sql, [
                ':nis' => $data['nis'],
                ':kelas' => $data['kelas']
            ]);
            
            // Set instance properties after successful creation
            $this->nis = $data['nis'];
            $this->kelas = $data['kelas'];
            
            error_log("New student created with NIS: {$data['nis']}, Class: {$data['kelas']}");
            return true;
        } catch (Exception $e) {
            // Handle duplicate NIS or other database errors
            error_log("Failed to create student: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find student by NIS
     * 
     * @param int $nis Student NIS to search for
     * @return array|null Student data if found, null otherwise
     * 
     * Requirements: 1.2 - Student information must be retrievable by NIS
     */
    public function findByNis($nis) {
        $sql = "SELECT * FROM siswa WHERE nis = :nis";
        return $this->db->fetchOne($sql, [':nis' => $nis]);
    }

    /**
     * Get all students
     * 
     * @return array List of all students
     */
    public function getAll() {
        $sql = "SELECT * FROM siswa ORDER BY nis";
        return $this->db->fetchAll($sql);
    }

    /**
     * Validate student data
     * 
     * @param array $data Student data to validate
     * @return array Array of error messages (empty if valid)
     * 
     * Requirements: 1.2 - Student information must be validated
     * Requirements: 1.6 - All required fields must be validated before submission
     */
    public function validate($data) {
        $errors = [];

        // Validate NIS (required, integer, max 10 digits)
        if (empty($data['nis']) || !is_numeric($data['nis'])) {
            $errors[] = 'NIS harus diisi dengan angka';
        } elseif (strlen((string)$data['nis']) > 10) {
            $errors[] = 'NIS maksimal 10 digit';
        } elseif ((int)$data['nis'] <= 0) {
            $errors[] = 'NIS harus berupa angka positif';
        }

        // Validate kelas (required, max 10 characters)
        if (empty($data['kelas'])) {
            $errors[] = 'Kelas harus diisi';
        } elseif (strlen($data['kelas']) > 10) {
            $errors[] = 'Kelas maksimal 10 karakter';
        }

        return $errors;
    }

    /**
     * Get student NIS
     */
    public function getNis() {
        return $this->nis;
    }

    /**
     * Get student class
     */
    public function getKelas(): ?string {
        return $this->kelas;
    }
}