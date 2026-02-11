<?php

require_once __DIR__ . '/Database.php';

class Location {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get all locations
     */
    public function getAll() {
        $query = "SELECT * FROM lokasi ORDER BY nama_lokasi ASC";
        return $this->db->fetchAll($query);
    }
    
    /**
     * Find location by ID
     */
    public function findById($id) {
        $query = "SELECT * FROM lokasi WHERE id_lokasi = :id";
        $result = $this->db->fetchOne($query, [':id' => $id]);
        return $result;
    }
    
    /**
     * Create new location
     */
    public function create($data) {
        $query = "INSERT INTO lokasi (nama_lokasi, deskripsi) VALUES (:nama_lokasi, :deskripsi)";
        
        try {
            $this->db->execute($query, [
                ':nama_lokasi' => $data['nama_lokasi'],
                ':deskripsi' => $data['deskripsi'] ?? null
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Update location
     */
    public function update($id, $data) {
        $query = "UPDATE lokasi SET nama_lokasi = :nama_lokasi, deskripsi = :deskripsi WHERE id_lokasi = :id";
        
        try {
            $this->db->execute($query, [
                ':nama_lokasi' => $data['nama_lokasi'],
                ':deskripsi' => $data['deskripsi'] ?? null,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Delete location
     */
    public function delete($id) {
        // First check if location is referenced by aspirations
        if ($this->isReferencedByAspirations($id)) {
            return false;
        }
        
        $query = "DELETE FROM lokasi WHERE id_lokasi = :id";
        
        try {
            $this->db->execute($query, [':id' => $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Check if location is referenced by aspirations
     */
    public function isReferencedByAspirations($id) {
        $query = "SELECT COUNT(*) as count FROM input_aspirasi WHERE id_lokasi = :id";
        $result = $this->db->fetchOne($query, [':id' => $id]);
        return $result && $result['count'] > 0;
    }
    
    /**
     * Validate location data
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['nama_lokasi'])) {
            $errors[] = 'Nama lokasi harus diisi';
        } elseif (strlen($data['nama_lokasi']) > 50) {
            $errors[] = 'Nama lokasi maksimal 50 karakter';
        }
        
        // Validate description (optional)
        if (!empty($data['deskripsi']) && strlen($data['deskripsi']) > 500) {
            $errors[] = 'Deskripsi maksimal 500 karakter';
        }
        
        // Check for duplicate location name
        if (!empty($data['nama_lokasi'])) {
            $existing = $this->findByName($data['nama_lokasi'], $data['id_lokasi'] ?? null);
            if ($existing) {
                $errors[] = 'Nama lokasi sudah ada';
            }
        }
        
        return $errors;
    }
    
    /**
     * Get location usage statistics
     */
    public function getUsageStatistics($id) {
        $query = "SELECT 
                    COUNT(*) as total_aspirations,
                    SUM(CASE WHEN status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses,
                    SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai
                FROM input_aspirasi 
                WHERE id_lokasi = ?";
        
        try {
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Location::getUsageStatistics: " . $e->getMessage());
            return [
                'total_aspirations' => 0,
                'menunggu' => 0,
                'proses' => 0,
                'selesai' => 0
            ];
        }
    }

    /**
     * Get recent aspirations for this location
     */
    public function getRecentAspirations($id, $limit = 5) {
        // Ensure limit is a positive integer
        $limit = max(1, (int)$limit);
        
        $query = "SELECT 
                    i.id_pelaporan,
                    i.nis,
                    s.nama as nama_siswa,
                    s.kelas,
                    i.keterangan,
                    i.status,
                    i.created_at,
                    k.ket_kategori
                FROM input_aspirasi i
                LEFT JOIN siswa s ON i.nis = s.nis
                LEFT JOIN kategori k ON i.id_kategori = k.id_kategori
                WHERE i.id_lokasi = ?
                ORDER BY i.created_at DESC
                LIMIT ?";
        
        try {
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Location::getRecentAspirations: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Find location by name (for duplicate checking)
     */
    private function findByName($name, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT * FROM lokasi WHERE nama_lokasi = :name AND id_lokasi != :id";
            $result = $this->db->fetchOne($query, [':name' => $name, ':id' => $excludeId]);
        } else {
            $query = "SELECT * FROM lokasi WHERE nama_lokasi = :name";
            $result = $this->db->fetchOne($query, [':name' => $name]);
        }
        return $result;
    }
}