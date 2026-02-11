<?php

/**
 * Session Management Class
 * 
 * Handles user sessions and authentication state
 */
class Session {
    
    public function __construct() {
        // Mulai session jika belum dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Start PHP session
        }
    }

    /**
     * Login admin user
     */
    public function login(string $username): void {
        $_SESSION['admin_logged_in'] = true;     // Set flag bahwa admin sudah login
        $_SESSION['admin_username'] = $username; // Simpan username admin di session
        $_SESSION['login_time'] = time();        // Simpan waktu login untuk timeout
    }

    /**
     * Logout admin user
     */
    public function logout(): void {
        session_unset();   // Hapus semua data session
        session_destroy(); // Destroy session
    }

    /**
     * Check if admin is logged in
     */
    public function isLoggedIn(): bool {
        // Cek apakah flag login ada dan bernilai true
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    /**
     * Get logged in admin username
     */
    public function getUsername(): ?string {
        return $_SESSION['admin_username'] ?? null;  // Return username atau null jika tidak ada
    }

    /**
     * Check session timeout (30 minutes)
     */
    public function isExpired(): bool {
        if (!isset($_SESSION['login_time'])) {  // Jika tidak ada waktu login
            return true;                        // Anggap expired
        }
        
        $timeout = 30 * 60; // 30 menit dalam detik
        // Cek apakah waktu sekarang - waktu login > timeout
        return (time() - $_SESSION['login_time']) > $timeout;
    }

    /**
     * Refresh session time
     */
    public function refresh(): void {
        if ($this->isLoggedIn()) {              // Jika masih login
            $_SESSION['login_time'] = time();   // Update waktu login ke waktu sekarang
        }
    }

    /**
     * Require admin authentication
     */
    public function requireAuth(): void {
        // Cek apakah admin belum login atau session sudah expired
        if (!$this->isLoggedIn() || $this->isExpired()) {
            $this->logout();                    // Logout jika expired
            header('Location: /admin/login');   // Redirect ke halaman login
            exit;                               // Hentikan eksekusi
        }
        $this->refresh();  // Refresh waktu session jika masih valid
    }
}