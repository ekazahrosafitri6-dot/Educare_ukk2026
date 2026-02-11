<?php

require_once __DIR__ . '/Database.php';

/**
 * Category Model
 * 
 * Handles category data operations
 */
class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get all categories
     */
    public function getAll() {
        $sql = "SELECT * FROM kategori ORDER BY ket_kategori";
        return $this->db->fetchAll($sql);
    }

    /**
     * Find category by ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM kategori WHERE id_kategori = :id";
        return $this->db->fetchOne($sql, [':id' => $id]);
    }

    /**
     * Create a new category
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO kategori (ket_kategori, deskripsi) VALUES (:ket_kategori, :deskripsi)";
        
        try {
            $this->db->execute($sql, [
                ':ket_kategori' => $data['ket_kategori'],
                ':deskripsi' => $data['deskripsi'] ?? null
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Update category
     */
    public function update($id, $data) {
        $sql = "UPDATE kategori SET ket_kategori = :ket_kategori, deskripsi = :deskripsi WHERE id_kategori = :id";
        
        try {
            $this->db->execute($sql, [
                ':ket_kategori' => $data['ket_kategori'],
                ':deskripsi' => $data['deskripsi'] ?? null,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete category
     */
    public function delete($id) {
        // First check if category is referenced by aspirations
        if ($this->isReferencedByAspirations($id)) {
            return false;
        }
        
        $sql = "DELETE FROM kategori WHERE id_kategori = :id";
        
        try {
            $this->db->execute($sql, [':id' => $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check if category is referenced by aspirations
     */
    public function isReferencedByAspirations($id) {
        $sql = "SELECT COUNT(*) as count FROM input_aspirasi WHERE id_kategori = :id";
        $result = $this->db->fetchOne($sql, [':id' => $id]);
        return $result && $result['count'] > 0;
    }

    /**
     * Validate category data
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['ket_kategori'])) {
            $errors[] = 'Nama kategori harus diisi';
        } elseif (strlen($data['ket_kategori']) > 30) {
            $errors[] = 'Nama kategori maksimal 30 karakter';
        }
        
        // Validate description (optional)
        if (!empty($data['deskripsi']) && strlen($data['deskripsi']) > 500) {
            $errors[] = 'Deskripsi maksimal 500 karakter';
        }
        
        // Check for duplicate category name
        if (!empty($data['ket_kategori'])) {
            $existing = $this->findByName($data['ket_kategori'], $data['id_kategori'] ?? null);
            if ($existing) {
                $errors[] = 'Nama kategori sudah ada';
            }
        }
        
        return $errors;
    }

    /**
     * Get category usage statistics
     */
    public function getUsageStatistics($id) {
        $sql = "SELECT 
                    COUNT(*) as total_aspirations,
                    SUM(CASE WHEN status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses,
                    SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai
                FROM input_aspirasi 
                WHERE id_kategori = ?";
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Category::getUsageStatistics: " . $e->getMessage());
            return [
                'total_aspirations' => 0,
                'menunggu' => 0,
                'proses' => 0,
                'selesai' => 0
            ];
        }
    }

    /**
     * Get recent aspirations for this category
     */
    public function getRecentAspirations($id, $limit = 5) {
        // Ensure limit is a positive integer
        $limit = max(1, (int)$limit);
        
        $sql = "SELECT 
                    i.id_pelaporan,
                    i.nis,
                    s.nama as nama_siswa,
                    s.kelas,
                    i.keterangan,
                    i.status,
                    i.created_at,
                    l.nama_lokasi
                FROM input_aspirasi i
                LEFT JOIN siswa s ON i.nis = s.nis
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                WHERE i.id_kategori = ?
                ORDER BY i.created_at DESC
                LIMIT ?";
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Category::getRecentAspirations: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Find category by name (for duplicate checking)
     */
    private function findByName($name, $excludeId = null) {
        if ($excludeId) {
            $sql = "SELECT * FROM kategori WHERE ket_kategori = :name AND id_kategori != :id";
            $result = $this->db->fetchOne($sql, [':name' => $name, ':id' => $excludeId]);
        } else {
            $sql = "SELECT * FROM kategori WHERE ket_kategori = :name";
            $result = $this->db->fetchOne($sql, [':name' => $name]);
        }
        return $result;
    }
}