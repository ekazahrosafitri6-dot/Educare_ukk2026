<?php

require_once __DIR__ . '/Database.php';

/**
 * AuditTrail Model
 * 
 * Handles audit trail logging for all aspiration changes
 * Requirements: 3.7, 6.4, 6.5 - Record timestamp for status changes and maintain audit trail
 */
class AuditTrail {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Log an audit event
     * 
     * @param int $id_pelaporan The aspiration report ID
     * @param string $action_type Type of action (status_change, feedback_added, created)
     * @param string|null $old_value Previous value (for changes)
     * @param string|null $new_value New value
     * @param string|null $admin_username Admin who made the change
     * @return bool Success status
     */
    public function logEvent(int $id_pelaporan, string $action_type, ?string $old_value = null, ?string $new_value = null, ?string $admin_username = null): bool {
        try {
            $sql = "INSERT INTO audit_trail (id_pelaporan, action_type, old_value, new_value, admin_username) 
                    VALUES (:id_pelaporan, :action_type, :old_value, :new_value, :admin_username)";
            
            $params = [
                ':id_pelaporan' => $id_pelaporan,
                ':action_type' => $action_type,
                ':old_value' => $old_value,
                ':new_value' => $new_value,
                ':admin_username' => $admin_username
            ];
            
            $this->db->execute($sql, $params);
            error_log("Audit Trail: Logged $action_type for aspiration $id_pelaporan by " . ($admin_username ?? 'system'));
            return true;
        } catch (Exception $e) {
            error_log("Audit Trail: Failed to log event - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get audit trail for a specific aspiration
     * 
     * @param int $id_pelaporan The aspiration report ID
     * @return array List of audit events
     */
    public function getAuditTrail(int $id_pelaporan): array {
        try {
            $sql = "SELECT * FROM audit_trail 
                    WHERE id_pelaporan = :id_pelaporan 
                    ORDER BY created_at ASC";
            
            return $this->db->fetchAll($sql, [':id_pelaporan' => $id_pelaporan]);
        } catch (Exception $e) {
            error_log("Audit Trail: Failed to get audit trail - " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get recent audit events (for admin dashboard)
     * 
     * @param int $limit Number of recent events to retrieve
     * @return array List of recent audit events
     */
    public function getRecentEvents(int $limit = 10): array {
        try {
            $sql = "SELECT at.*, i.nis, i.lokasi, k.ket_kategori 
                    FROM audit_trail at
                    INNER JOIN input_aspirasi i ON at.id_pelaporan = i.id_pelaporan
                    LEFT JOIN kategori k ON i.id_kategori = k.id_kategori
                    ORDER BY at.created_at DESC 
                    LIMIT :limit";
            
            return $this->db->fetchAll($sql, [':limit' => $limit]);
        } catch (Exception $e) {
            error_log("Audit Trail: Failed to get recent events - " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get audit statistics
     * 
     * @return array Statistics about audit events
     */
    public function getStatistics(): array {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_events,
                        SUM(CASE WHEN action_type = 'status_change' THEN 1 ELSE 0 END) as status_changes,
                        SUM(CASE WHEN action_type = 'feedback_added' THEN 1 ELSE 0 END) as feedback_additions,
                        SUM(CASE WHEN action_type = 'created' THEN 1 ELSE 0 END) as creations,
                        COUNT(DISTINCT id_pelaporan) as affected_aspirations,
                        COUNT(DISTINCT admin_username) as active_admins
                    FROM audit_trail";
            
            $result = $this->db->fetchOne($sql);
            return $result ?: [
                'total_events' => 0,
                'status_changes' => 0,
                'feedback_additions' => 0,
                'creations' => 0,
                'affected_aspirations' => 0,
                'active_admins' => 0
            ];
        } catch (Exception $e) {
            error_log("Audit Trail: Failed to get statistics - " . $e->getMessage());
            return [
                'total_events' => 0,
                'status_changes' => 0,
                'feedback_additions' => 0,
                'creations' => 0,
                'affected_aspirations' => 0,
                'active_admins' => 0
            ];
        }
    }

    /**
     * Format audit event for display
     * 
     * @param array $event Audit event data
     * @return string Formatted description
     */
    public function formatEvent(array $event): string {
        $timestamp = date('d/m/Y H:i:s', strtotime($event['created_at']));
        $admin = $event['admin_username'] ?? 'System';
        
        switch ($event['action_type']) {
            case 'created':
                return "[$timestamp] Aspirasi dibuat oleh sistem";
                
            case 'status_change':
                $old = $event['old_value'] ?? 'Unknown';
                $new = $event['new_value'] ?? 'Unknown';
                return "[$timestamp] Status diubah dari '$old' ke '$new' oleh $admin";
                
            case 'feedback_added':
                return "[$timestamp] Feedback ditambahkan oleh $admin: " . substr($event['new_value'] ?? '', 0, 50) . (strlen($event['new_value'] ?? '') > 50 ? '...' : '');
                
            case 'feedback_updated':
                return "[$timestamp] Feedback diperbarui oleh $admin: " . substr($event['new_value'] ?? '', 0, 50) . (strlen($event['new_value'] ?? '') > 50 ? '...' : '');
                
            default:
                return "[$timestamp] Aksi tidak dikenal oleh $admin";
        }
    }
}