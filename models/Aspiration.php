<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/AuditTrail.php';

/**
 * Aspiration Model
 * 
 * Handles aspiration data operations
 */
class Aspiration {
    private Database $db;
    private AuditTrail $auditTrail;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->auditTrail = new AuditTrail();
    }

    /**
     * Create a new aspiration (simplified version)
     */
    public function create(array $data): int|bool {
        try {
            error_log("=== Aspiration Model: Starting create process ===");
            error_log("Input data: " . json_encode($data));
            
            // Validate required fields
            $requiredFields = ['nis', 'id_kategori', 'id_lokasi', 'ket'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    error_log("Missing required field: $field");
                    return false;
                }
            }
            
            // Generate simple unique ID using timestamp + random
            $timestamp = time();
            $random = rand(10, 99);
            $id_pelaporan = (int) (substr($timestamp, -3) . $random); // Last 3 digits of timestamp + 2 random = 5 digits
            
            // Ensure it's in 5-digit range
            if ($id_pelaporan < 10000) {
                $id_pelaporan += 10000;
            } elseif ($id_pelaporan > 99999) {
                $id_pelaporan = $id_pelaporan % 90000 + 10000;
            }
            
            error_log("Generated ID: $id_pelaporan");
            
            // Check if ID already exists (simple check)
            $checkSql = "SELECT id_pelaporan FROM input_aspirasi WHERE id_pelaporan = :id LIMIT 1";
            $existing = $this->db->fetchOne($checkSql, [':id' => $id_pelaporan]);
            
            if ($existing) {
                // If exists, just increment by 1
                $id_pelaporan++;
                if ($id_pelaporan > 99999) {
                    $id_pelaporan = 10000;
                }
                error_log("ID existed, using incremented ID: $id_pelaporan");
            }
            
            // Step 1: Insert to input_aspirasi table
            error_log("Inserting to input_aspirasi table...");
            $sql1 = "INSERT INTO input_aspirasi (id_pelaporan, nis, id_kategori, id_lokasi, ket) 
                     VALUES (:id_pelaporan, :nis, :id_kategori, :id_lokasi, :ket)";
            
            $params1 = [
                ':id_pelaporan' => $id_pelaporan,
                ':nis' => (int) $data['nis'],
                ':id_kategori' => (int) $data['id_kategori'],
                ':id_lokasi' => (int) $data['id_lokasi'],
                ':ket' => (string) $data['ket']
            ];
            
            error_log("SQL1: $sql1");
            error_log("Params1: " . json_encode($params1));
            
            $this->db->execute($sql1, $params1);
            error_log("✅ Input aspirasi inserted successfully");
            
            // Step 2: Insert to aspirasi table
            error_log("Inserting to aspirasi table...");
            $sql2 = "INSERT INTO aspirasi (id_pelaporan, id_kategori, status) 
                     VALUES (:id_pelaporan, :id_kategori, :status)";
            
            $params2 = [
                ':id_pelaporan' => $id_pelaporan,
                ':id_kategori' => (int) $data['id_kategori'],
                ':status' => $data['status'] ?? 'Menunggu'
            ];
            
            error_log("SQL2: $sql2");
            error_log("Params2: " . json_encode($params2));
            
            $this->db->execute($sql2, $params2);
            error_log("✅ Aspirasi tracking inserted successfully");
            
            // Skip audit trail for now to isolate the issue
            error_log("✅ Aspiration created successfully with ID: $id_pelaporan");
            return $id_pelaporan;
            
        } catch (Exception $e) {
            error_log("❌ Error in create(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Generate unique report ID
     */
    private function generateUniqueReportId(): int {
        $maxAttempts = 100; // Increase attempts for better uniqueness
        $attempts = 0;
        
        do {
            // Generate random 5-digit number (10000-99999)
            $id = rand(10000, 99999);
            $attempts++;
            
            // Use helper method to check uniqueness
            if ($this->isIdUnique($id)) {
                error_log("Generated unique ID: $id after $attempts attempts");
                return $id;
            }
            
            error_log("ID $id already exists, trying again (attempt $attempts)");
            
        } while ($attempts < $maxAttempts);
        
        // If still not unique after max attempts, use timestamp-based approach
        error_log("Failed to generate unique random ID after $maxAttempts attempts, using timestamp approach");
        
        // Use current time in microseconds for better uniqueness
        $microtime = microtime(true);
        $timestamp = (int) ($microtime * 1000); // Convert to milliseconds
        
        // Take last 5 digits and ensure it's in valid range
        $id = $timestamp % 90000 + 10000; // Ensures 5-digit number between 10000-99999
        
        // Final check with incremental approach if needed
        $originalId = $id;
        $incrementAttempts = 0;
        
        while (!$this->isIdUnique($id) && $incrementAttempts < 10000) {
            $id++;
            if ($id > 99999) {
                $id = 10000; // Wrap around to start of 5-digit range
            }
            $incrementAttempts++;
        }
        
        if ($this->isIdUnique($id)) {
            error_log("Generated unique timestamp-based ID: $id (original: $originalId, increments: $incrementAttempts)");
            return $id;
        }
        
        // Last resort - use current timestamp seconds + random
        $fallbackId = (time() % 90000) + 10000;
        error_log("Using fallback ID generation: $fallbackId");
        return $fallbackId;
    }

    /**
     * Get location ID by name, create if doesn't exist
     */
    private function getLocationIdByName(string $locationName): int {
        if (empty($locationName)) {
            return 1; // Default location ID
        }
        
        // Try to find existing location
        $sql = "SELECT id_lokasi FROM lokasi WHERE nama_lokasi = :nama_lokasi LIMIT 1";
        $result = $this->db->fetchOne($sql, [':nama_lokasi' => $locationName]);
        
        if ($result) {
            return (int) $result['id_lokasi'];
        }
        
        // Create new location if not found
        $sql = "INSERT INTO lokasi (nama_lokasi) VALUES (:nama_lokasi)";
        $this->db->execute($sql, [':nama_lokasi' => $locationName]);
        
        // Get the new location ID
        $sql = "SELECT LAST_INSERT_ID() as new_id";
        $result = $this->db->fetchOne($sql);
        
        return (int) $result['new_id'];
    }

    /**
     * Find aspiration by ID (using id_pelaporan)
     */
    public function findById(int $id): ?array {
        $sql = "SELECT a.*, i.nis, l.nama_lokasi as lokasi, i.ket, s.kelas, k.ket_kategori 
                FROM aspirasi a 
                INNER JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
                LEFT JOIN siswa s ON i.nis = s.nis 
                LEFT JOIN kategori k ON a.id_kategori = k.id_kategori 
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                WHERE i.id_pelaporan = :id";
        return $this->db->fetchOne($sql, [':id' => $id]);
    }

    /**
     * Find aspiration by Report ID
     */
    public function findByReportId(int $id_pelaporan): ?array {
        $sql = "SELECT * FROM input_aspirasi WHERE id_pelaporan = :id_pelaporan";
        return $this->db->fetchOne($sql, [':id_pelaporan' => $id_pelaporan]);
    }

    /**
     * Find aspirations by student NIS
     */
    public function findByStudent(int $nis): array {
        error_log("=== findByStudent called for NIS: $nis ===");
        
        // First, try to get from aspirasi table (processed data)
        $sql = "SELECT a.*, i.nis, l.nama_lokasi as lokasi, i.ket, a.created_at as submitted_at, k.ket_kategori 
                FROM aspirasi a 
                INNER JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
                LEFT JOIN kategori k ON a.id_kategori = k.id_kategori 
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                WHERE i.nis = :nis 
                ORDER BY a.created_at DESC";
        
        try {
            $result = $this->db->fetchAll($sql, [':nis' => $nis]);
            error_log("Main query returned " . count($result) . " results");
            
            foreach($result as $index => $asp) {
                error_log("  [$index] ID: " . $asp['id_pelaporan'] . " - Status: " . $asp['status'] . " - Ket: " . $asp['ket']);
            }
            
            if (!empty($result)) {
                error_log("Returning main query results");
                return $result;
            }
        } catch (Exception $e) {
            // If aspirasi table doesn't exist or error, fall back to input_aspirasi only
            error_log("Error fetching from aspirasi: " . $e->getMessage());
        }
        
        // Fallback: Get from input_aspirasi only (unprocessed data)
        error_log("Using fallback query");
        $sql = "SELECT i.id_pelaporan, i.nis, i.id_kategori, l.nama_lokasi as lokasi, i.ket, 
                       k.ket_kategori, 'Belum Diproses' as status, NULL as feedback,
                       i.created_at
                FROM input_aspirasi i
                LEFT JOIN kategori k ON i.id_kategori = k.id_kategori 
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                WHERE i.nis = :nis 
                ORDER BY i.id_pelaporan DESC";
        
        $fallbackResult = $this->db->fetchAll($sql, [':nis' => $nis]);
        error_log("Fallback query returned " . count($fallbackResult) . " results");
        
        return $fallbackResult;
    }

    /**
     * Update aspiration status
     */
    public function updateStatus(int $id, string $status, ?string $admin_username = null): bool {
        // Update in aspirasi table using id_pelaporan
        try {
            // First, get the current status for audit trail
            $currentData = $this->db->fetchOne(
                "SELECT status FROM aspirasi WHERE id_pelaporan = :id",
                [':id' => $id]
            );
            $oldStatus = $currentData['status'] ?? 'Unknown';
            
            $sql = "UPDATE aspirasi SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id_pelaporan = :id";
            $this->db->execute($sql, [
                ':status' => $status,
                ':id' => $id
            ]);
            
            // Log audit trail for status change
            $this->auditTrail->logEvent(
                $id,
                'status_change',
                $oldStatus,
                $status,
                $admin_username
            );
            
            error_log("Status updated successfully for id_pelaporan: $id from $oldStatus to $status by " . ($admin_username ?? 'unknown'));
            return true;
        } catch (Exception $e) {
            error_log("Error updating status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Add or update feedback to aspiration (replaces existing feedback)
     */
    public function addFeedback(int $id, string $feedback, ?string $admin_username = null): bool {
        // Update in aspirasi table using id_pelaporan - this replaces any existing feedback
        try {
            // First, get the current feedback for audit trail
            $currentData = $this->db->fetchOne(
                "SELECT feedback FROM aspirasi WHERE id_pelaporan = :id",
                [':id' => $id]
            );
            $oldFeedback = $currentData['feedback'] ?? null;
            
            // Update with new feedback (replaces old one)
            $sql = "UPDATE aspirasi SET feedback = :feedback, updated_at = CURRENT_TIMESTAMP WHERE id_pelaporan = :id";
            $this->db->execute($sql, [
                ':feedback' => $feedback,
                ':id' => $id
            ]);
            
            // Log audit trail - differentiate between new feedback and updated feedback
            $actionType = empty($oldFeedback) ? 'feedback_added' : 'feedback_updated';
            $this->auditTrail->logEvent(
                $id,
                $actionType,
                $oldFeedback,
                $feedback,
                $admin_username
            );
            
            $action = empty($oldFeedback) ? 'added' : 'updated';
            error_log("Feedback $action successfully for id_pelaporan: $id by " . ($admin_username ?? 'unknown'));
            return true;
        } catch (Exception $e) {
            error_log("Error adding/updating feedback: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get filtered list of aspirations with pagination and sorting
     */
    public function getFilteredList(array $filters = [], int $page = 1, int $limit = 20, string $sortBy = 'id_pelaporan', string $sortOrder = 'DESC'): array {
        $offset = ($page - 1) * $limit;
        $params = [];
        $whereConditions = [];

        // Try to get from aspirasi table first (if exists)
        try {
            $sql = "SELECT a.*, i.nis, l.nama_lokasi as lokasi, i.ket, a.created_at as submitted_at, s.kelas, k.ket_kategori 
                    FROM aspirasi a 
                    INNER JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
                    LEFT JOIN siswa s ON i.nis = s.nis 
                    LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
                    LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi";

            // Apply filters
            if (!empty($filters['search'])) {
                $searchTerm = '%' . $filters['search'] . '%';
                $whereConditions[] = "(a.id_pelaporan LIKE :search1 OR i.nis LIKE :search2 OR s.kelas LIKE :search3 OR k.ket_kategori LIKE :search4 OR l.nama_lokasi LIKE :search5 OR i.ket LIKE :search6 OR a.status LIKE :search7)";
                $params[':search1'] = $searchTerm;
                $params[':search2'] = $searchTerm;
                $params[':search3'] = $searchTerm;
                $params[':search4'] = $searchTerm;
                $params[':search5'] = $searchTerm;
                $params[':search6'] = $searchTerm;
                $params[':search7'] = $searchTerm;
            }

            if (!empty($filters['nis'])) {
                $whereConditions[] = "i.nis = :nis";
                $params[':nis'] = $filters['nis'];
            }

            if (!empty($filters['id_kategori'])) {
                $whereConditions[] = "a.id_kategori = :id_kategori";
                $params[':id_kategori'] = $filters['id_kategori'];
            }

            if (!empty($filters['status'])) {
                $whereConditions[] = "a.status = :status";
                $params[':status'] = $filters['status'];
            }

            // Date range filters
            if (!empty($filters['date_from'])) {
                $whereConditions[] = "DATE(a.created_at) >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }

            if (!empty($filters['date_to'])) {
                $whereConditions[] = "DATE(a.created_at) <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }

            // Month filter (format: YYYY-MM)
            if (!empty($filters['month'])) {
                $whereConditions[] = "DATE_FORMAT(a.created_at, '%Y-%m') = :month";
                $params[':month'] = $filters['month'];
            }

            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(" AND ", $whereConditions);
            }

            $sql .= " ORDER BY a.created_at DESC LIMIT :limit OFFSET :offset";
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;

            return $this->db->fetchAll($sql, $params);
        } catch (Exception $e) {
            error_log("Error fetching from aspirasi table: " . $e->getMessage());
        }

        // Fallback: Get from input_aspirasi only
        $params = [];
        $whereConditions = [];
        
        $sql = "SELECT i.id_pelaporan, i.nis, i.id_kategori, l.nama_lokasi as lokasi, i.ket, 
                       s.kelas, k.ket_kategori, 'Belum Diproses' as status, NULL as feedback
                FROM input_aspirasi i
                LEFT JOIN siswa s ON i.nis = s.nis 
                LEFT JOIN kategori k ON i.id_kategori = k.id_kategori
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi";

        // Apply filters
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $whereConditions[] = "(i.id_pelaporan LIKE :search1 OR i.nis LIKE :search2 OR s.kelas LIKE :search3 OR k.ket_kategori LIKE :search4 OR l.nama_lokasi LIKE :search5 OR i.ket LIKE :search6)";
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
            $params[':search5'] = $searchTerm;
            $params[':search6'] = $searchTerm;
        }

        if (!empty($filters['nis'])) {
            $whereConditions[] = "i.nis = :nis";
            $params[':nis'] = $filters['nis'];
        }

        if (!empty($filters['id_kategori'])) {
            $whereConditions[] = "i.id_kategori = :id_kategori";
            $params[':id_kategori'] = $filters['id_kategori'];
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $sql .= " ORDER BY i.id_pelaporan DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Get total count for filtered aspirations
     */
    public function getFilteredCount(array $filters = []): int {
        $params = [];
        $whereConditions = [];

        // Try aspirasi table first
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM aspirasi a 
                    INNER JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
                    LEFT JOIN siswa s ON i.nis = s.nis 
                    LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
                    LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi";

            if (!empty($filters['search'])) {
                $searchTerm = '%' . $filters['search'] . '%';
                $whereConditions[] = "(a.id_pelaporan LIKE :search1 OR i.nis LIKE :search2 OR s.kelas LIKE :search3 OR k.ket_kategori LIKE :search4 OR l.nama_lokasi LIKE :search5 OR i.ket LIKE :search6 OR a.status LIKE :search7)";
                $params[':search1'] = $searchTerm;
                $params[':search2'] = $searchTerm;
                $params[':search3'] = $searchTerm;
                $params[':search4'] = $searchTerm;
                $params[':search5'] = $searchTerm;
                $params[':search6'] = $searchTerm;
                $params[':search7'] = $searchTerm;
            }

            if (!empty($filters['nis'])) {
                $whereConditions[] = "i.nis = :nis";
                $params[':nis'] = $filters['nis'];
            }

            if (!empty($filters['id_kategori'])) {
                $whereConditions[] = "a.id_kategori = :id_kategori";
                $params[':id_kategori'] = $filters['id_kategori'];
            }

            if (!empty($filters['status'])) {
                $whereConditions[] = "a.status = :status";
                $params[':status'] = $filters['status'];
            }

            // Date range filters
            if (!empty($filters['date_from'])) {
                $whereConditions[] = "DATE(a.created_at) >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }

            if (!empty($filters['date_to'])) {
                $whereConditions[] = "DATE(a.created_at) <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }

            // Month filter (format: YYYY-MM)
            if (!empty($filters['month'])) {
                $whereConditions[] = "DATE_FORMAT(a.created_at, '%Y-%m') = :month";
                $params[':month'] = $filters['month'];
            }

            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(" AND ", $whereConditions);
            }

            $result = $this->db->fetchOne($sql, $params);
            return (int) $result['total'];
        } catch (Exception $e) {
            error_log("Error counting from aspirasi table: " . $e->getMessage());
        }

        // Fallback: Count from input_aspirasi
        $params = [];
        $whereConditions = [];
        
        $sql = "SELECT COUNT(*) as total FROM input_aspirasi i
                LEFT JOIN siswa s ON i.nis = s.nis 
                LEFT JOIN kategori k ON i.id_kategori = k.id_kategori
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi";

        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $whereConditions[] = "(i.id_pelaporan LIKE :search1 OR i.nis LIKE :search2 OR s.kelas LIKE :search3 OR k.ket_kategori LIKE :search4 OR l.nama_lokasi LIKE :search5 OR i.ket LIKE :search6)";
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
            $params[':search5'] = $searchTerm;
            $params[':search6'] = $searchTerm;
        }

        if (!empty($filters['nis'])) {
            $whereConditions[] = "i.nis = :nis";
            $params[':nis'] = $filters['nis'];
        }

        if (!empty($filters['id_kategori'])) {
            $whereConditions[] = "i.id_kategori = :id_kategori";
            $params[':id_kategori'] = $filters['id_kategori'];
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $result = $this->db->fetchOne($sql, $params);
        return (int) $result['total'];
    }

    /**
     * Get all aspirations (simple list)
     */
    public function getAll(): array {
        // Try to get from aspirasi table first
        try {
            $sql = "SELECT a.*, i.nis, l.nama_lokasi as lokasi, i.ket, a.created_at as submitted_at, s.kelas, k.ket_kategori 
                    FROM aspirasi a 
                    INNER JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
                    LEFT JOIN siswa s ON i.nis = s.nis 
                    LEFT JOIN kategori k ON a.id_kategori = k.id_kategori 
                    LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                    ORDER BY a.created_at DESC";
            
            $result = $this->db->fetchAll($sql);
            if (!empty($result)) {
                return $result;
            }
        } catch (Exception $e) {
            error_log("Error fetching from aspirasi table: " . $e->getMessage());
        }

        // Fallback: Get from input_aspirasi only
        $sql = "SELECT i.id_pelaporan, i.nis, i.id_kategori, l.nama_lokasi as lokasi, i.ket, 
                       s.kelas, k.ket_kategori, 'Belum Diproses' as status, NULL as feedback
                FROM input_aspirasi i
                LEFT JOIN siswa s ON i.nis = s.nis 
                LEFT JOIN kategori k ON i.id_kategori = k.id_kategori 
                LEFT JOIN lokasi l ON i.id_lokasi = l.id_lokasi
                ORDER BY i.id_pelaporan DESC";
        
        return $this->db->fetchAll($sql);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): array {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses,
                    SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai
                FROM aspirasi";
        
        $result = $this->db->fetchOne($sql);
        return $result ?: ['total' => 0, 'menunggu' => 0, 'proses' => 0, 'selesai' => 0];
    }

    /**
     * Get report data with filters
     */
    public function getReportData(array $filters = []): array {
        // Build WHERE clause
        $whereConditions = [];
        $params = [];
        
        if (!empty($filters['date_from'])) {
            $whereConditions[] = "DATE(ia.created_at) >= :date_from";
            $params[':date_from'] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $whereConditions[] = "DATE(ia.created_at) <= :date_to";
            $params[':date_to'] = $filters['date_to'];
        }
        
        if (!empty($filters['month'])) {
            $whereConditions[] = "DATE_FORMAT(ia.created_at, '%Y-%m') = :month";
            $params[':month'] = $filters['month'];
        }
        
        if (!empty($filters['id_kategori'])) {
            $whereConditions[] = "ia.id_kategori = :id_kategori";
            $params[':id_kategori'] = $filters['id_kategori'];
        }
        
        if (!empty($filters['status'])) {
            $whereConditions[] = "a.status = :status";
            $params[':status'] = $filters['status'];
        }
        
        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
        
        // Get summary statistics
        $summarySql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN a.status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
                        SUM(CASE WHEN a.status = 'Proses' THEN 1 ELSE 0 END) as proses,
                        SUM(CASE WHEN a.status = 'Selesai' THEN 1 ELSE 0 END) as selesai
                       FROM input_aspirasi ia
                       JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                       JOIN kategori k ON ia.id_kategori = k.id_kategori
                       $whereClause";
        
        $summary = $this->db->fetchOne($summarySql, $params) ?: 
                   ['total' => 0, 'menunggu' => 0, 'proses' => 0, 'selesai' => 0];
        
        // Get detailed data
        $detailSql = "SELECT 
                        ia.id_pelaporan,
                        ia.nis,
                        s.kelas,
                        k.ket_kategori,
                        l.nama_lokasi as lokasi,
                        ia.ket,
                        a.status,
                        a.feedback,
                        ia.created_at
                      FROM input_aspirasi ia
                      JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                      JOIN kategori k ON ia.id_kategori = k.id_kategori
                      LEFT JOIN siswa s ON ia.nis = s.nis
                      LEFT JOIN lokasi l ON ia.id_lokasi = l.id_lokasi
                      $whereClause
                      ORDER BY ia.created_at DESC";
        
        $details = $this->db->fetchAll($detailSql, $params);
        
        // Get category breakdown
        $categorySql = "SELECT 
                          k.ket_kategori,
                          COUNT(*) as count,
                          SUM(CASE WHEN a.status = 'Selesai' THEN 1 ELSE 0 END) as selesai_count
                        FROM input_aspirasi ia
                        JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                        JOIN kategori k ON ia.id_kategori = k.id_kategori
                        $whereClause
                        GROUP BY k.id_kategori, k.ket_kategori
                        ORDER BY count DESC";
        
        $categoryBreakdown = $this->db->fetchAll($categorySql, $params);
        
        return [
            'summary' => $summary,
            'details' => $details,
            'categoryBreakdown' => $categoryBreakdown,
            'filters' => $filters
        ];
    }

    /**
     * Delete aspiration by ID (using id_pelaporan)
     */
    public function delete(int $id_pelaporan): bool {
        try {
            error_log("Aspiration Model: Attempting to delete aspiration with id_pelaporan: $id_pelaporan");
            
            // Step 1: Delete from aspirasi table first (using id_pelaporan)
            $sql1 = "DELETE FROM aspirasi WHERE id_pelaporan = :id_pelaporan";
            $this->db->execute($sql1, [':id_pelaporan' => $id_pelaporan]);
            error_log("Aspiration Model: Deleted from aspirasi table");
            
            // Step 2: Delete from input_aspirasi table
            $sql2 = "DELETE FROM input_aspirasi WHERE id_pelaporan = :id_pelaporan";
            $this->db->execute($sql2, [':id_pelaporan' => $id_pelaporan]);
            error_log("Aspiration Model: Deleted from input_aspirasi table");
            
            // Step 3: Log audit trail for deletion
            $this->auditTrail->logEvent(
                $id_pelaporan,
                'deleted',
                null,
                'Aspirasi dihapus oleh admin',
                null // Will be set by the controller
            );
            
            error_log("Aspiration Model: Aspiration deleted successfully");
            return true;
        } catch (Exception $e) {
            error_log("Aspiration Model: Failed to delete aspiration - " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Delete aspiration with admin audit trail
     */
    public function deleteAspiration(int $id_pelaporan, ?string $admin_username = null): bool {
        try {
            error_log("Aspiration Model: Attempting to delete aspiration with admin audit: $id_pelaporan");
            
            // Step 1: Delete from audit_trail table first (to avoid foreign key constraints)
            $sql0 = "DELETE FROM audit_trail WHERE id_pelaporan = :id_pelaporan";
            $this->db->execute($sql0, [':id_pelaporan' => $id_pelaporan]);
            error_log("Aspiration Model: Deleted from audit_trail table");
            
            // Step 2: Delete from aspirasi table (using id_pelaporan directly)
            $sql1 = "DELETE FROM aspirasi WHERE id_pelaporan = :id_pelaporan";
            $this->db->execute($sql1, [':id_pelaporan' => $id_pelaporan]);
            error_log("Aspiration Model: Deleted from aspirasi table");
            
            // Step 3: Delete from input_aspirasi table
            $sql2 = "DELETE FROM input_aspirasi WHERE id_pelaporan = :id_pelaporan";
            $this->db->execute($sql2, [':id_pelaporan' => $id_pelaporan]);
            error_log("Aspiration Model: Deleted from input_aspirasi table");
            
            error_log("Aspiration Model: Aspiration deleted successfully by admin: " . ($admin_username ?? 'Unknown'));
            return true;
        } catch (Exception $e) {
            error_log("Aspiration Model: Failed to delete aspiration - " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Check if ID is truly unique across all tables
     */
    private function isIdUnique(int $id): bool {
        try {
            // Check input_aspirasi table
            $sql1 = "SELECT COUNT(*) as count FROM input_aspirasi WHERE id_pelaporan = :id_pelaporan";
            $result1 = $this->db->fetchOne($sql1, [':id_pelaporan' => $id]);
            
            // Check aspirasi table
            $sql2 = "SELECT COUNT(*) as count FROM aspirasi WHERE id_pelaporan = :id_pelaporan";
            $result2 = $this->db->fetchOne($sql2, [':id_pelaporan' => $id]);
            
            $count1 = (int) ($result1['count'] ?? 0);
            $count2 = (int) ($result2['count'] ?? 0);
            
            $isUnique = ($count1 === 0 && $count2 === 0);
            
            if (!$isUnique) {
                error_log("ID $id is NOT unique - found in input_aspirasi: $count1, aspirasi: $count2");
            }
            
            return $isUnique;
        } catch (Exception $e) {
            error_log("Error checking ID uniqueness for ID $id: " . $e->getMessage());
            // If we can't check uniqueness, assume it's not unique to be safe
            return false;
        }
    }

    /**
     * Get audit trail for an aspiration
     * 
     * Requirements: 6.5 - Display modification history
     */
    public function getAuditTrail(int $id_pelaporan): array {
        return $this->auditTrail->getAuditTrail($id_pelaporan);
    }
}