<?php

/**
 * Database Connection Class
 * 
 * Handles database connection and basic query operations
 */
class Database {
    private static $instance = null;  // Static variable untuk menyimpan instance singleton
    private $connection;              // Variable untuk menyimpan koneksi PDO
    private $config;                  // Variable untuk menyimpan konfigurasi database

    private function __construct() {
        $this->config = require_once __DIR__ . '/../config/database.php';  // Load konfigurasi database
        $this->connect();  // Panggil method untuk membuat koneksi
    }

    /**
     * Get singleton instance of Database
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {          // Jika instance belum ada
            self::$instance = new self();        // Buat instance baru
        }
        return self::$instance;                  // Return instance yang sudah ada
    }
    
    /**
     * Reset singleton instance (for testing)
     */
    public static function resetInstance(): void {
        self::$instance = null;  // Reset instance ke null (untuk testing)
    }

    /**
     * Establish database connection
     */
    private function connect(): void {
        try {
            // Buat DSN string untuk koneksi MySQL
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset={$this->config['charset']}";
            
            // Buat koneksi PDO dengan konfigurasi yang sudah disiapkan
            $this->connection = new PDO(
                $dsn,                           // Data Source Name
                $this->config['username'],      // Username database
                $this->config['password'],      // Password database
                $this->config['options']        // Options PDO (error mode, fetch mode, dll)
            );
        } catch (PDOException $e) {
            // Jika koneksi gagal, throw exception dengan pesan error
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get PDO connection
     */
    public function getConnection(): PDO {
        return $this->connection;  // Return objek koneksi PDO
    }

    /**
     * Execute a prepared statement with parameters
     */
    public function execute(string $sql, array $params = []): PDOStatement {
        try {
            $stmt = $this->connection->prepare($sql);  // Siapkan prepared statement
            $stmt->execute($params);                   // Eksekusi dengan parameter
            return $stmt;                              // Return statement object
        } catch (PDOException $e) {
            // Jika query gagal, throw exception dengan pesan error
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    /**
     * Fetch single row
     */
    public function fetchOne(string $sql, array $params = []): ?array {
        $stmt = $this->execute($sql, $params);  // Eksekusi query
        $result = $stmt->fetch();               // Ambil satu baris hasil
        return $result ?: null;                 // Return hasil atau null jika tidak ada
    }

    /**
     * Fetch all rows
     */
    public function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->execute($sql, $params);  // Eksekusi query
        return $stmt->fetchAll();               // Return semua baris hasil
    }

    /**
     * Get last inserted ID
     */
    public function getLastInsertId(): string {
        return $this->connection->lastInsertId();  // Return ID terakhir yang di-insert
    }

    /**
     * Begin transaction
     */
    public function beginTransaction(): bool {
        return $this->connection->beginTransaction();  // Mulai transaksi database
    }

    /**
     * Commit transaction
     */
    public function commit(): bool {
        return $this->connection->commit();  // Commit transaksi (simpan perubahan)
    }

    /**
     * Rollback transaction
     */
    public function rollback(): bool {
        return $this->connection->rollBack();  // Rollback transaksi (batalkan perubahan)
    }

    /**
     * Test database connection
     */
    public function testConnection(): bool {
        try {
            $this->connection->query('SELECT 1');  // Coba jalankan query sederhana
            return true;                           // Return true jika berhasil
        } catch (PDOException $e) {
            return false;                          // Return false jika gagal
        }
    }
}