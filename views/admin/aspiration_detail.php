<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aspirasi - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/admin-auth-guard.js"></script>
    <style>
        /* Professional SweetAlert Styling */
        .swal-professional-popup {
            border-radius: 16px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.05) !important;
            border: none !important;
            backdrop-filter: blur(10px) !important;
            background: rgba(255, 255, 255, 0.98) !important;
            max-width: 480px !important;
            width: 90% !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
        
        .swal-professional-title {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            font-size: 18px !important;
            margin-bottom: 12px !important;
            letter-spacing: -0.025em !important;
            line-height: 1.4 !important;
            padding: 0 24px !important;
            text-align: center !important;
        }
        
        .swal-professional-content {
            color: #6b7280 !important;
            font-size: 14px !important;
            line-height: 1.5 !important;
            margin-bottom: 20px !important;
            padding: 0 24px !important;
            text-align: center !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }
        
        .swal-professional-confirm {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            box-shadow: 0 4px 12px rgba(46, 90, 167, 0.4) !important;
            transition: all 0.2s ease !important;
            color: white !important;
            min-width: 100px !important;
        }
        
        .swal-professional-confirm:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 16px rgba(46, 90, 167, 0.5) !important;
            background: linear-gradient(135deg, var(--primary-700) 0%, var(--primary-800) 100%) !important;
        }
        
        .swal-professional-cancel {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            color: #64748b !important;
            transition: all 0.2s ease !important;
            min-width: 100px !important;
        }
        
        .swal-professional-cancel:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #475569 !important;
            transform: translateY(-1px) !important;
        }
        
        .swal-professional-input {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.2s ease !important;
            background: #fafbfc !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        
        .swal-professional-input:focus {
            border-color: var(--primary-600) !important;
            box-shadow: 0 0 0 3px rgba(46, 90, 167, 0.1) !important;
            background: white !important;
            outline: none !important;
        }
        
        .swal-professional-textarea {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.2s ease !important;
            background: #fafbfc !important;
            resize: vertical !important;
            min-height: 100px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        
        .swal-professional-textarea:focus {
            border-color: var(--primary-600) !important;
            box-shadow: 0 0 0 3px rgba(46, 90, 167, 0.1) !important;
            background: white !important;
            outline: none !important;
        }
        
        /* Success/Error/Warning Styling */
        .swal-success-popup { 
            border-left: 4px solid #10b981 !important; 
        }
        .swal-error-popup { 
            border-left: 4px solid #ef4444 !important; 
        }
        .swal-warning-popup { 
            border-left: 4px solid #f59e0b !important; 
        }
        .swal-loading-popup { 
            border-left: 4px solid #6366f1 !important; 
        }
        
        .swal-success-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
        }
        
        .swal-error-confirm {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }
        
        .swal-warning-confirm {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4) !important;
        }
        
        /* Icon Container */
        .swal-icon-container {
            width: 64px; 
            height: 64px; 
            border-radius: 16px; 
            margin: 0 auto 20px;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            position: relative;
        }
        
        .swal-icon { 
            font-size: 24px; 
            color: white; 
            z-index: 1; 
        }
        
        .swal-icon-primary { 
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700)); 
            box-shadow: 0 8px 25px rgba(46, 90, 167, 0.25); 
        }
        .swal-icon-success { 
            background: linear-gradient(135deg, #10b981, #059669); 
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.25); 
        }
        .swal-icon-error { 
            background: linear-gradient(135deg, #ef4444, #dc2626); 
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.25); 
        }
        .swal-icon-warning { 
            background: linear-gradient(135deg, #f59e0b, #d97706); 
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.25); 
        }
        
        /* Animations */
        .swal-fade-in { 
            animation: swalFadeIn 0.3s ease-out; 
        }
        .swal-fade-out { 
            animation: swalFadeOut 0.2s ease-in; 
        }
        
        @keyframes swalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        
        @keyframes swalFadeOut {
            from { opacity: 1; transform: scale(1) translateY(0); }
            to { opacity: 0; transform: scale(0.95) translateY(-10px); }
        }
        
        .swal-loading-spinner {
            width: 20px; 
            height: 20px; 
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white; 
            border-radius: 50%; 
            animation: swalSpin 1s linear infinite;
        }
        
        @keyframes swalSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* SweetAlert2 Container Fixes */
        .swal2-container {
            padding: 20px !important;
        }
        
        .swal2-popup {
            padding: 24px !important;
        }
        
        .swal2-html-container {
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
        }
        
        .swal2-actions {
            margin-top: 24px !important;
            gap: 12px !important;
            justify-content: center !important;
        }
        
        .swal2-input, .swal2-textarea, .swal2-select {
            margin: 16px 0 !important;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .swal-professional-popup {
                max-width: 95% !important;
                margin: 10px !important;
            }
            
            .swal-professional-title {
                font-size: 16px !important;
                padding: 0 16px !important;
            }
            
            .swal-professional-content {
                font-size: 13px !important;
                padding: 0 16px !important;
            }
            
            .swal2-popup {
                padding: 20px !important;
            }
        }
    </style>
    <style>
        /* Page specific styles */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            padding: var(--spacing-2) var(--spacing-4);
            background: var(--primary-600);
            color: white;
            text-decoration: none;
            border-radius: var(--radius-lg);
            font-weight: 500;
            font-size: var(--font-size-sm);
            transition: all var(--transition-fast);
            margin-top: var(--spacing-4);
        }
        
        .back-button:hover {
            background: var(--primary-700);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }
        
        /* Side by side layout */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-4);
            margin-bottom: var(--spacing-4);
            align-items: start;
        }
        
        .detail-section, .audit-section {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-lg);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .detail-header {
            padding: var(--spacing-4);
            border-bottom: 1px solid rgba(134, 197, 255, 0.15);
            background: rgba(253, 252, 248, 0.5);
        }
        
        .detail-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0;
        }
        
        .detail-subtitle {
            font-size: var(--font-size-xs);
            color: var(--primary-600);
            margin: var(--spacing-1) 0 0 0;
        }
        
        .detail-content {
            padding: var(--spacing-4);
        }
        
        .detail-row {
            display: flex;
            margin-bottom: var(--spacing-3);
            padding: var(--spacing-2) 0;
            border-bottom: 1px solid rgba(134, 197, 255, 0.1);
        }
        
        .detail-label {
            font-weight: 600;
            width: 140px;
            color: var(--primary-800);
            font-size: var(--font-size-sm);
            flex-shrink: 0;
        }
        
        .detail-value {
            flex: 1;
            color: var(--primary-900);
            font-size: var(--font-size-sm);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: var(--font-size-xs);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .status-menunggu { 
            background: rgba(239, 143, 0, 0.1);
            color: var(--warning-600);
            border: 1px solid rgba(239, 143, 0, 0.3);
        }
        
        .status-proses { 
            background: rgba(0, 56, 188, 0.1);
            color: var(--primary-900);
            border: 1px solid rgba(0, 56, 188, 0.3);
        }
        
        .status-selesai { 
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-600);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .action-buttons {
            margin-top: var(--spacing-4);
            padding-top: var(--spacing-4);
            border-top: 1px solid rgba(134, 197, 255, 0.15);
            display: flex;
            gap: var(--spacing-3);
        }
        
        .btn {
            padding: var(--spacing-3) var(--spacing-4);
            border: none;
            border-radius: var(--radius-lg);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            font-weight: 500;
            font-size: var(--font-size-sm);
            transition: all var(--transition-fast);
        }
        
        .btn-primary { 
            background: var(--primary-900); 
            color: white; 
        }
        
        .btn-primary:hover { 
            background: var(--primary-700); 
            transform: translateY(-1px);
        }
        
        .btn-warning { 
            background: var(--warning-600); 
            color: white; 
        }
        
        .btn-warning:hover { 
            background: #d97706; 
            transform: translateY(-1px);
        }
        
        .btn-danger { 
            background: #dc2626; 
            color: white; 
        }
        
        .btn-danger:hover { 
            background: #b91c1c; 
            transform: translateY(-1px);
        }
        
        /* Audit section styles */
        .audit-content {
            padding: var(--spacing-4);
        }
        
        .audit-trail {
            background: rgba(253, 252, 248, 0.3);
            border-left: 4px solid var(--primary-900);
            padding: var(--spacing-4);
            border-radius: var(--radius-lg);
        }
        
        .audit-event {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--spacing-3);
            margin-bottom: var(--spacing-3);
            border-top: 3px solid var(--success-600);
            box-shadow: 0 1px 3px rgba(46, 90, 167, 0.1);
        }
        
        .audit-event.status-change {
            border-left-color: var(--warning-600);
        }
        
        .audit-event.feedback-added {
            border-left-color: var(--primary-900);
        }
        
        .audit-event.feedback-updated {
            border-left-color: var(--warning-600);
        }
        
        .audit-timestamp {
            font-size: var(--font-size-xs);
            color: var(--primary-600);
            margin-bottom: var(--spacing-2);
            font-weight: 500;
        }
        
        .audit-description {
            font-size: var(--font-size-sm);
            color: var(--primary-800);
        }
        
        .audit-empty {
            text-align: center;
            padding: var(--spacing-6);
            color: var(--primary-600);
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-main-wrapper {
                margin-left: 0;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-4);
            }
        }
        
        @media (max-width: 768px) {
            .admin-main-content {
                padding: var(--spacing-4);
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-4);
            }
            
            .detail-row {
                flex-direction: column;
                gap: var(--spacing-1);
            }
            
            .detail-label {
                width: auto;
                margin-bottom: var(--spacing-1);
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <!-- Sidebar Header -->
            <div class="admin-sidebar-header">
                <a href="/admin/dashboard" class="admin-brand">
                    <div class="admin-brand-logo">
                        <div class="icon icon-school icon-lg"></div>
                    </div>
                    <div class="admin-brand-text">
                        <h1>EduCare</h1>
                        <p class="admin-brand-subtitle">Admin Panel</p>
                    </div>
                </a>
            </div>
            
            <!-- Sidebar Navigation -->
            <nav class="admin-sidebar-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Menu Utama</div>
                    <ul class="admin-nav-menu">
                        <li class="admin-nav-item">
                            <a href="/admin/dashboard" class="admin-nav-link">
                                <div class="admin-nav-icon">
                                    <div class="icon icon-chart-bar icon-sm"></div>
                                </div>
                                Dashboard
                            </a>
                        </li>
                        <li class="admin-nav-item">
                            <a href="/admin/aspirations" class="admin-nav-link active">
                                <div class="admin-nav-icon">
                                    <div class="icon icon-clipboard icon-sm"></div>
                                </div>
                                Kelola Aspirasi
                            </a>
                        </li>
                        <li class="admin-nav-item">
                            <a href="/admin/categories" class="admin-nav-link">
                                <div class="admin-nav-icon">
                                    <div class="icon icon-folder icon-sm"></div>
                                </div>
                                Kelola Kategori
                            </a>
                        </li>
                        <li class="admin-nav-item">
                            <a href="/admin/locations" class="admin-nav-link">
                                <div class="admin-nav-icon">
                                    <div class="icon icon-map-pin icon-sm"></div>
                                </div>
                                Kelola Lokasi
                            </a>
                        </li>
                        <li class="admin-nav-item">
                            <a href="/admin/reports" class="admin-nav-link">
                                <div class="admin-nav-icon">
                                    <div class="icon icon-document-report icon-sm"></div>
                                </div>
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Sidebar User Section -->
            <div class="admin-sidebar-user">
                <div class="admin-user-profile">
                    <div class="admin-user-profile-avatar">
                        A
                    </div>
                    <div class="admin-user-profile-info">
                        <p class="admin-user-profile-name">Administrator</p>
                        <p class="admin-user-profile-role">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Sidebar Overlay for Mobile -->
        <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Main Content Wrapper -->
        <div class="admin-main-wrapper">
            <!-- Top Header -->
            <header class="admin-top-header">
                <div class="admin-header-left">
                    <button class="admin-mobile-menu-btn" id="mobileMenuBtn">
                        <div class="icon icon-menu icon-sm"></div>
                    </button>
                    <div class="admin-page-breadcrumb">
                        <a href="/admin/aspirations">Kelola Aspirasi</a>
                        <span class="breadcrumb-separator">›</span>
                        <span>Detail Aspirasi</span>
                    </div>
                </div>
                
                <div class="admin-user-menu">
                    <div class="admin-user-info">
                        <p class="admin-user-name">Administrator</p>
                        <p class="admin-user-role">Admin</p>
                    </div>
                    <div class="admin-user-avatar">
                        A
                    </div>
                    <a href="/admin/logout" class="btn btn-outline btn-sm">Logout</a>
                </div>
            </header>
    
            <!-- Main Content -->
            <main class="admin-main-content">
                <!-- Page Header -->
                <div class="admin-page-header">
                    <h1 class="admin-page-title">Detail Aspirasi #<?= htmlspecialchars($aspiration['id_pelaporan']) ?></h1>
                    <p class="admin-page-subtitle">Informasi lengkap dan riwayat perubahan aspirasi</p>
                </div>
                
                <!-- Side by Side Layout -->
                <div class="detail-grid">
                    <!-- Left Column: Detail Section -->
                    <div class="detail-section">
                        <div class="detail-header">
                            <h2 class="detail-title">Informasi Aspirasi</h2>
                            <p class="detail-subtitle">Data lengkap aspirasi yang diajukan siswa</p>
                        </div>
                        
                        <div class="detail-content">
                            <div class="detail-row">
                                <div class="detail-label">ID Pelaporan:</div>
                                <div class="detail-value"><?= htmlspecialchars($aspiration['id_pelaporan']) ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">NIS Siswa:</div>
                                <div class="detail-value"><?= htmlspecialchars($aspiration['nis']) ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Kelas:</div>
                                <div class="detail-value"><?= htmlspecialchars($aspiration['kelas'] ?? 'Tidak diketahui') ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Kategori:</div>
                                <div class="detail-value"><?= htmlspecialchars($aspiration['ket_kategori'] ?? 'Tidak diketahui') ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Lokasi:</div>
                                <div class="detail-value"><?= htmlspecialchars($aspiration['lokasi']) ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Keterangan:</div>
                                <div class="detail-value"><?= nl2br(htmlspecialchars($aspiration['ket'])) ?></div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Status:</div>
                                <div class="detail-value">
                                    <span class="status-badge status-<?= strtolower($aspiration['status']) ?>">
                                        <?= htmlspecialchars($aspiration['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <?php if (!empty($aspiration['feedback'])): ?>
                            <div class="detail-row">
                                <div class="detail-label">Feedback:</div>
                                <div class="detail-value"><?= nl2br(htmlspecialchars($aspiration['feedback'])) ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="detail-row">
                                <div class="detail-label">Tanggal Dibuat:</div>
                                <div class="detail-value">
                                    <?php 
                                    $createdAt = $aspiration['created_at'] ?? $aspiration['submitted_at'] ?? null;
                                    echo $createdAt ? date('d/m/Y H:i:s', strtotime($createdAt)) : 'Tidak diketahui';
                                    ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($aspiration['updated_at'])): ?>
                            <div class="detail-row">
                                <div class="detail-label">Terakhir Diperbarui:</div>
                                <div class="detail-value"><?= date('d/m/Y H:i:s', strtotime($aspiration['updated_at'])) ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="action-buttons">
                                <button class="btn btn-warning" onclick="updateStatus(<?= $aspiration['id_pelaporan'] ?>)">
                                    <div class="icon icon-refresh icon-sm"></div>
                                    Ubah Status
                                </button>
                                <button class="btn btn-primary" onclick="addFeedback(<?= $aspiration['id_pelaporan'] ?>)">
                                    <div class="icon icon-chat icon-sm"></div>
                                    Tambah Feedback
                                </button>
                                <button class="btn btn-danger" onclick="deleteAspiration(<?= $aspiration['id_pelaporan'] ?>)">
                                    <div class="icon icon-trash icon-sm"></div>
                                    Hapus Aspirasi
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Audit Trail Section -->
                    <div class="audit-section">
                        <div class="detail-header">
                            <h3 class="detail-title">Riwayat Perubahan</h3>
                            <p class="detail-subtitle">Audit trail semua perubahan aspirasi</p>
                        </div>
                        
                        <?php if (!empty($auditTrail)): ?>
                        <div class="audit-content">
                            <div class="audit-trail">
                                <?php foreach ($auditTrail as $event): ?>
                                <div class="audit-event <?= $event['action_type'] ?>">
                                    <div class="audit-timestamp">
                                        <?= date('d/m/Y H:i:s', strtotime($event['created_at'])) ?>
                                    </div>
                                    <div class="audit-description">
                                        <?php
                                        $admin = $event['admin_username'] ?? 'System';
                                        
                                        switch ($event['action_type']) {
                                            case 'created':
                                                echo "Aspirasi dibuat oleh sistem";
                                                break;
                                                
                                            case 'status_change':
                                                $old = $event['old_value'] ?? 'Unknown';
                                                $new = $event['new_value'] ?? 'Unknown';
                                                echo "Status diubah dari '<strong>$old</strong>' ke '<strong>$new</strong>' oleh <strong>$admin</strong>";
                                                break;
                                                
                                            case 'feedback_added':
                                                $feedback = htmlspecialchars($event['new_value'] ?? '');
                                                $shortFeedback = strlen($feedback) > 100 ? substr($feedback, 0, 100) . '...' : $feedback;
                                                echo "Feedback ditambahkan oleh <strong>$admin</strong>:<br>";
                                                echo "<em>\"$shortFeedback\"</em>";
                                                break;
                                                
                                            case 'feedback_updated':
                                                $feedback = htmlspecialchars($event['new_value'] ?? '');
                                                $shortFeedback = strlen($feedback) > 100 ? substr($feedback, 0, 100) . '...' : $feedback;
                                                echo "Feedback diperbarui oleh <strong>$admin</strong>:<br>";
                                                echo "<em>\"$shortFeedback\"</em>";
                                                break;
                                                
                                            default:
                                                echo "Aksi tidak dikenal oleh <strong>$admin</strong>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="audit-content">
                            <div class="audit-empty">
                                <div style="font-size: 3rem; margin-bottom: var(--spacing-3); opacity: 0.5;">📋</div>
                                <h4 style="color: var(--primary-700); margin-bottom: var(--spacing-2);">Belum Ada Riwayat</h4>
                                <p style="color: var(--primary-600); margin: 0;">Belum ada perubahan yang dilakukan pada aspirasi ini.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Back Button -->
                <a href="/admin/aspirations" class="back-button">
                    <div class="icon icon-arrow-left icon-sm"></div>
                    Kembali ke Daftar Aspirasi
                </a>
            </main>
        </div>
    </div>
    
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, JavaScript ready');
            console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
        });
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    if (sidebar && overlay) {
                        sidebar.classList.toggle('open');
                        overlay.classList.toggle('active');
                    }
                });
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    if (sidebar && overlay) {
                        sidebar.classList.remove('open');
                        overlay.classList.remove('active');
                    }
                });
            }
        });
        
        function updateStatus(id) {
            Swal.fire({
                title: 'Update Status',
                html: `
                    <div style="text-align: center; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-primary">
                            <div class="swal-icon">📋</div>
                        </div>
                        <p class="swal-professional-content">
                            Pilih status baru untuk aspirasi <strong>#${id}</strong>
                        </p>
                    </div>
                `,
                input: 'select',
                inputOptions: {
                    'Menunggu': 'Menunggu Review',
                    'Proses': 'Sedang Diproses',
                    'Selesai': 'Selesai Ditangani'
                },
                inputPlaceholder: 'Pilih status baru...',
                showCancelButton: true,
                confirmButtonText: 'Update Status',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-professional-popup',
                    title: 'swal-professional-title',
                    confirmButton: 'swal-professional-confirm',
                    cancelButton: 'swal-professional-cancel',
                    input: 'swal-professional-input'
                },
                showClass: {
                    popup: 'swal-fade-in'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silakan pilih status terlebih dahulu'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('status', result.value);
                    
                    fetch('/admin/update-status', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Status Berhasil Diperbarui',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-success">
                                            <div class="swal-icon">✓</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Status aspirasi telah berhasil diperbarui
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Selesai',
                                customClass: {
                                    popup: 'swal-professional-popup swal-success-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-success-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                },
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal Memperbarui Status',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-error">
                                            <div class="swal-icon">✕</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            ${data.message || 'Terjadi kesalahan saat memperbarui status'}
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Coba Lagi',
                                customClass: {
                                    popup: 'swal-professional-popup swal-error-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-error-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + error.message,
                            icon: 'error',
                            confirmButtonColor: '#2E5AA7'
                        });
                    });
                }
            });
        }
        
        function addFeedback(id) {
            Swal.fire({
                title: 'Tambah Feedback',
                html: `
                    <div style="text-align: center; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-success">
                            <div class="swal-icon">💬</div>
                        </div>
                        <p class="swal-professional-content">
                            Berikan feedback untuk aspirasi <strong>#${id}</strong>
                        </p>
                        <?php if (!empty($aspiration['feedback'])): ?>
                        <p class="swal-professional-content" style="color: #f59e0b; font-size: 12px; background: #fef3c7; padding: 8px; border-radius: 6px; margin-top: 12px;">
                            ⚠️ <strong>Perhatian:</strong> Feedback baru akan mengganti feedback yang sudah ada
                        </p>
                        <?php endif; ?>
                    </div>
                `,
                input: 'textarea',
                inputPlaceholder: 'Tulis feedback Anda di sini...\n\nContoh:\n• Status sudah ditindaklanjuti\n• Sedang dalam proses perbaikan\n• Telah selesai diperbaiki',
                inputAttributes: {
                    style: 'min-height: 120px;'
                },
                <?php if (!empty($aspiration['feedback'])): ?>
                inputValue: '<?= addslashes($aspiration['feedback']) ?>',
                <?php endif; ?>
                showCancelButton: true,
                confirmButtonText: '<?= !empty($aspiration['feedback']) ? 'Perbarui Feedback' : 'Kirim Feedback' ?>',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-professional-popup',
                    title: 'swal-professional-title',
                    confirmButton: 'swal-professional-confirm swal-success-confirm',
                    cancelButton: 'swal-professional-cancel',
                    input: 'swal-professional-textarea'
                },
                showClass: {
                    popup: 'swal-fade-in'
                },
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return 'Feedback tidak boleh kosong'
                    }
                    if (value.trim().length < 10) {
                        return 'Feedback minimal 10 karakter'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('feedback', result.value.trim());
                    
                    fetch('/admin/add-feedback', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const actionText = <?= !empty($aspiration['feedback']) ? '"diperbarui"' : '"dikirim"' ?>;
                            Swal.fire({
                                title: `Feedback Berhasil ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}`,
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-success">
                                            <div class="swal-icon">✓</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Feedback untuk aspirasi <strong>#${id}</strong> telah berhasil ${actionText}
                                        </p>
                                        <p class="swal-professional-content" style="font-size: 12px; color: #9ca3af;">
                                            Siswa akan menerima notifikasi feedback terbaru Anda
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Selesai',
                                customClass: {
                                    popup: 'swal-professional-popup swal-success-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-success-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                },
                                timer: 4000,
                                timerProgressBar: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal Mengirim Feedback',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-error">
                                            <div class="swal-icon">✕</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            ${data.message || 'Terjadi kesalahan saat mengirim feedback'}
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Coba Lagi',
                                customClass: {
                                    popup: 'swal-professional-popup swal-error-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-error-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + error.message,
                            icon: 'error',
                            confirmButtonColor: '#2E5AA7'
                        });
                    });
                }
            });
        }
        
        // Delete aspiration function
        function deleteAspiration(id) {
            console.log('deleteAspiration called with id:', id);
            
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak tersedia. Delete ID: ' + id);
                return;
            }
            
            Swal.fire({
                title: 'Hapus Aspirasi',
                html: `
                    <div style="text-align: center; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-error">
                            <div class="swal-icon">🗑️</div>
                        </div>
                        <p class="swal-professional-content">
                            Apakah Anda yakin ingin menghapus aspirasi <strong>#${id}</strong>?<br>
                            <span style="color: #dc2626; font-weight: 600;">Tindakan ini tidak dapat dibatalkan!</span>
                        </p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-professional-popup swal-error-popup',
                    title: 'swal-professional-title',
                    confirmButton: 'swal-professional-confirm swal-error-confirm',
                    cancelButton: 'swal-professional-cancel'
                },
                showClass: {
                    popup: 'swal-fade-in'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show professional loading
                    Swal.fire({
                        title: 'Menghapus Aspirasi',
                        html: `
                            <div style="text-align: center; margin: 0 0 24px 0;">
                                <div class="swal-icon-container swal-icon-error">
                                    <div class="swal-loading-spinner"></div>
                                </div>
                                <p class="swal-professional-content">
                                    Sedang menghapus aspirasi...
                                </p>
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-professional-popup swal-loading-popup',
                            title: 'swal-professional-title'
                        }
                    });
                    
                    const formData = new FormData();
                    formData.append('id', id);
                    
                    fetch('/admin/delete-aspiration', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Aspirasi Berhasil Dihapus',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-success">
                                            <div class="swal-icon">✓</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Aspirasi <strong>#${id}</strong> telah berhasil dihapus dari sistem
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Kembali ke Daftar',
                                customClass: {
                                    popup: 'swal-professional-popup swal-success-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-success-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                },
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '/admin/aspirations';
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal Menghapus Aspirasi',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-error">
                                            <div class="swal-icon">✕</div>
                                        </div>
                                        <p class="swal-professional-content">
                                            ${data.message || 'Terjadi kesalahan saat menghapus aspirasi'}
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: 'Coba Lagi',
                                customClass: {
                                    popup: 'swal-professional-popup swal-error-popup',
                                    title: 'swal-professional-title',
                                    confirmButton: 'swal-professional-confirm swal-error-confirm'
                                },
                                showClass: {
                                    popup: 'swal-fade-in'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + error.message,
                            icon: 'error',
                            confirmButtonColor: '#2E5AA7'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>