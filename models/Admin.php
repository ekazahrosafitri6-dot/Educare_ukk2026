<?php

/**
 * Admin Model
 * 
 * Handles admin authentication and management
 */
class Admin {
    private Database $db;      // Instance database untuk koneksi
    private string $username;  // Username admin yang sedang login
    private string $password;  // Password admin (tidak digunakan untuk penyimpanan)

    public function __construct() {
        $this->db = Database::getInstance();  // Ambil instance database singleton
    }

    /**
     * Authenticate admin with username and password
     */
    public function authenticate(string $username, string $password): bool {
        try {
            // Query untuk mengambil data admin berdasarkan username
            $sql = "SELECT username, password FROM admin WHERE username = ?";
            $result = $this->db->fetchOne($sql, [$username]);  // Eksekusi query
            
            // Jika data ditemukan dan password cocok (menggunakan password_verify)
            if ($result && password_verify($password, $result['password'])) {
                $this->username = $result['username'];  // Simpan username ke property
                return true;                            // Return true jika berhasil
            }
            
            return false;  // Return false jika gagal
        } catch (Exception $e) {
            error_log("Admin authentication error: " . $e->getMessage());  // Log error
            return false;  // Return false jika ada exception
        }
    }

    /**
     * Find admin by username
     */
    public function findByUsername(string $username): ?array {
        try {
            // Query untuk mencari admin berdasarkan username
            $sql = "SELECT username FROM admin WHERE username = ?";
            return $this->db->fetchOne($sql, [$username]);  // Return data admin atau null
        } catch (Exception $e) {
            error_log("Find admin error: " . $e->getMessage());  // Log error jika ada
            return null;  // Return null jika error
        }
    }

    /**
     * Create new admin (for setup purposes)
     */
    public function create(string $username, string $password): bool {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash password
            // Query untuk insert admin baru
            $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
            $this->db->execute($sql, [$username, $hashedPassword]);  // Eksekusi insert
            return true;  // Return true jika berhasil
        } catch (Exception $e) {
            error_log("Create admin error: " . $e->getMessage());  // Log error
            return false;  // Return false jika gagal
        }
    }

    /**
     * Get current username
     */
    public function getUsername(): string {
        return $this->username ?? '';  // Return username atau string kosong
    }

    /**
     * Update admin password
     */
    public function updatePassword(string $username, string $newPassword): bool {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);  // Hash password baru
            // Query untuk update password
            $sql = "UPDATE admin SET password = ? WHERE username = ?";
            $this->db->execute($sql, [$hashedPassword, $username]);  // Eksekusi update
            return true;  // Return true jika berhasil
        } catch (Exception $e) {
            error_log("Update password error: " . $e->getMessage());  // Log error
            return false;  // Return false jika gagal
        }
    }
}