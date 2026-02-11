<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aspirasi - EduCare</title>
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
            background:  var( --primary-900) !important;
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
            background:  var( --primary-900) !important;
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
            border-color: var(--primary-00) !important;
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
            background: var( --success-500) !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
        }
        
        .swal-error-confirm {
            background: var(--error-500) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }
        
        .swal-warning-confirm {
            background: var(--warning-600) !important;
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
            background: var(--primary-900); 
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.25); 
        }
        .swal-icon-success { 
            background: var(--success-500); 
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.25); 
        }
        .swal-icon-error { 
            background: var(--error-500); 
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.25); 
        }
        .swal-icon-warning { 
            background: var(--warning-600); 
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
        
        /* Success Styling */
        .swal-success-popup {
            border-left: 4px solid #10b981 !important;
        }
        
        .swal-success-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
        }
        
        .swal-success-confirm:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5) !important;
        }
        
        /* Error Styling */
        .swal-error-popup {
            border-left: 4px solid #ef4444 !important;
        }
        
        .swal-error-confirm {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }
        
        .swal-error-confirm:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.5) !important;
        }
        
        /* Warning Styling */
        .swal-warning-popup {
            border-left: 4px solid #f59e0b !important;
        }
        
        .swal-warning-confirm {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4) !important;
        }
        
        .swal-warning-confirm:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5) !important;
        }
        
        /* Loading Styling */
        .swal-loading-popup {
            border-left: 4px solid #6366f1 !important;
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
        
        .swal-icon-container::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.05));
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }
        
        .swal-icon {
            font-size: 24px;
            color: white;
            z-index: 1;
        }
        
        /* Status Colors */
        .swal-icon-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.25);
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
        
        /* Timer Progress Bar */
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #2563eb, #1d4ed8) !important;
            height: 3px !important;
        }
        
        /* Backdrop */
        .swal2-backdrop-show {
            background: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(4px) !important;
        }
        
        /* Smooth Animations */
        .swal-fade-in {
            animation: swalFadeIn 0.3s ease-out;
        }
        
        .swal-fade-out {
            animation: swalFadeOut 0.2s ease-in;
        }
        
        @keyframes swalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        @keyframes swalFadeOut {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            to {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }
        }
        
        /* Loading Animation */
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
    <style>
        /* Page specific styles */
        .filter-section {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-lg);
            padding: var(--spacing-4);
            margin-bottom: var(--spacing-4);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .filter-title {
            font-size: var(--font-size-base);
            font-weight: 600;
            color: var(--primary-900);
            margin-bottom: var(--spacing-3);
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: var(--spacing-3);
            margin-bottom: var(--spacing-3);
        }
        
        .filter-section .form-group {
            margin-bottom: 0;
        }
        
        .filter-section .form-label {
            font-size: var(--font-size-sm);
            margin-bottom: var(--spacing-1);
            font-weight: 500;
            color: var(--primary-800);
        }
        
        .filter-section .form-input,
        .filter-section .form-select {
            padding: var(--spacing-2) var(--spacing-3);
            font-size: var(--font-size-sm);
            height: auto;
            color: var(--primary-800);
            border: 1px solid rgba(134, 197, 255, 0.3);
        }
        
        .filter-section .form-input:focus,
        .filter-section .form-select:focus {
            border-color: var(--primary-600);
            box-shadow: 0 0 0 3px rgba(46, 90, 167, 0.1);
        }
        
        .filter-actions {
            display: flex;
            gap: var(--spacing-2);
            justify-content: flex-end;
        }
        
        .filter-actions .btn {
            padding: var(--spacing-3) var(--spacing-4);
            font-size: var(--font-size-sm);
            font-weight: 500;
        }
        
        .data-section {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .data-header {
            padding: var(--spacing-4);
            border-bottom: 1px solid rgba(134, 197, 255, 0.15);
            background: rgba(253, 252, 248, 0.5);
        }
        
        .data-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0;
        }
        
        .data-subtitle {
            font-size: var(--font-size-xs);
            color: var(--primary-900);
            margin: var(--spacing-1) 0 0 0;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .aspirations-table {
            width: 100%;
            border-collapse: collapse;
            font-size: var(--font-size-sm);
        }
        
        .aspirations-table th {
            background: rgba(134, 197, 255, 0.08);
            color: var(--primary-800);
            padding: var(--spacing-3) var(--spacing-2);
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
            border-bottom: 1px solid rgba(134, 197, 255, 0.2);
            white-space: nowrap;
        }
        
        .aspirations-table td {
            padding: var(--spacing-3) var(--spacing-2);
            border-bottom: 1px solid rgba(134, 197, 255, 0.1);
            font-size: 15px;
            color: var(--primary-800);
            vertical-align: middle;
        }
        
        .aspirations-table tbody tr:hover {
            background: rgba(134, 197, 255, 0.03);
        }
        
        .aspirations-table tbody tr:nth-child(even) {
            background: rgba(253, 252, 248, 0.3);
        }
        
        .aspirations-table tbody tr:nth-child(even):hover {
            background: rgba(134, 197, 255, 0.05);
        }
        
        /* Clean table cell styling */
        .table-cell-id {
            font-weight: 600;
            color: var(--primary-900);
            min-width: 60px;
        }
        
        .table-cell-date {
            min-width: 80px;
            font-size: 12px;
            color: var(--primary-600);
        }
        
        .table-cell-student {
            min-width: 100px;
        }
        
        .table-cell-student-nis {
            font-weight: 600;
            color: var(--primary-900);
        }
        
        .table-cell-student-class {
            font-size: 11px;
            color: var(--primary-500);
            margin-top: 2px;
        }
        
        .table-cell-category {
            min-width: 90px;
            font-size: 12px;
        }
        
        .table-cell-location {
            min-width: 80px;
            font-size: 12px;
        }
        
        .table-cell-description {
            max-width: 150px;
            font-size: 10px;
            line-height: 1.3;
        }
        
        .table-cell-description-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
        
        .table-cell-status {
            min-width: 80px;
            text-align: center;
        }
        
        .table-cell-actions {
            min-width: 130px;
            text-align: center;
        }
        
        .action-buttons {
            display: flex;
            gap: var(--spacing-1);
            justify-content: center;
            align-items: center;
        }
        
        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
            cursor: pointer;
            background: none;
            padding: 0;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-detail {
            background: rgba(0, 56, 188, 0.1);
            color: var(--primary-900);
            border-color: rgba(0, 56, 188, 0.3);
        }
        
        .btn-detail:hover {
            background: rgba(0, 56, 188, 0.2);
            border-color: var(--primary-900);
            color: var(--primary-600);
        }
        
        .btn-status {
            background: rgba(239, 143, 0, 0.1);
            color: var(--warning-600);
            border-color: rgba(239, 143, 0, 0.3);
        }
        
        .btn-status:hover {
            background: rgba(239, 143, 0, 0.2);
            border-color: var(--warning-600);
            color: #d97706;
        }
        
        .btn-feedback {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-600);
            border-color: rgba(16, 185, 129, 0.3);
        }
        
        .btn-feedback:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: var(--success-600);
            color: #047857;
        }
        
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-color: rgba(239, 68, 68, 0.3);
        }
        
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #dc2626;
            color: #b91c1c;
        }
        
        /* Icon styling for actions */
        .action-icon {
            width: 14px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Status badge improvements */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 600;
            border-radius: var(--radius-md);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                justify-content: stretch;
            }
            
            .filter-actions .btn {
                flex: 1;
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
            </nav>>
            
            <!-- Sidebar User Section -->
            <div class="admin-sidebar-user">
                <div class="admin-user-profile">
                    <div class="admin-user-profile-avatar">
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    </div>
                    <div class="admin-user-profile-info">
                        <p class="admin-user-profile-name"><?= htmlspecialchars($username) ?></p>
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
                        <span>Kelola Aspirasi</span>
                    </div>
                </div>
                
                <div class="admin-user-menu">
                    <div class="admin-user-info">
                        <p class="admin-user-name"><?= htmlspecialchars($username) ?></p>
                        <p class="admin-user-role">Administrator</p>
                    </div>
                    <div class="admin-user-avatar">
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    </div>
                    <a href="/admin/logout" class="btn btn-outline btn-sm">Logout</a>
                </div>
            </header>
    
            <!-- Main Content -->
            <main class="admin-main-content">
                <!-- Page Header -->
                <div class="admin-page-header">
                    <h1 class="admin-page-title">Kelola Aspirasi</h1>
                    <p class="admin-page-subtitle">Kelola dan pantau semua aspirasi siswa dengan mudah</p>
                </div>
                
                <!-- Filter & Search Section -->
                <div class="filter-section">
                    <h3 class="filter-title">Filter & Pencarian</h3>
                    
                    <!-- Global Search Box -->
                    <div style="margin-bottom: var(--spacing-4);">
                        <form method="GET" action="/admin/aspirations" style="display: flex; gap: var(--spacing-2); align-items: end;">
                            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                                <label for="search" class="form-label" style="font-weight: 600; color: var(--primary-900);">Pencarian Global:</label>
                                <input type="search" id="search" name="search" class="form-input" 
                                       placeholder="Cari berdasarkan ID, NIS, nama siswa, kategori, lokasi, deskripsi, status..."
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                       style="padding-right: 40px; font-size: var(--font-size-sm); border: 2px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-lg);">
                            </div>
                            <button type="submit" class="btn btn-primary" style="height: fit-content; padding: var(--spacing-3) var(--spacing-4);">
                                <div class="icon icon-search icon-sm" style="margin-right: 4px;"></div>
                                Cari
                            </button>
                            <?php if (!empty($_GET['search'])): ?>
                                <a href="/admin/aspirations" class="btn btn-outline" style="height: fit-content; padding: var(--spacing-3) var(--spacing-4);">
                                    <div class="icon icon-x icon-sm" style="margin-right: 4px;"></div>
                                    Clear
                                </a>
                            <?php endif; ?>
                            
                            <!-- Preserve other filters when searching -->
                            <?php foreach (['date_from', 'date_to', 'month', 'nis', 'id_kategori', 'status'] as $filter): ?>
                                <?php if (!empty($_GET[$filter])): ?>
                                    <input type="hidden" name="<?= $filter ?>" value="<?= htmlspecialchars($_GET[$filter]) ?>">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </form>
                    </div>
                    
                    <!-- Advanced Filters -->
                    <form method="GET" action="/admin/aspirations">
                        <!-- Preserve search term when filtering -->
                        <?php if (!empty($_GET['search'])): ?>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                        <?php endif; ?>
                        
                        <div class="filter-grid">
                            <div class="form-group">
                                <label for="date_from" class="form-label">Tanggal Dari:</label>
                                <input type="date" id="date_from" name="date_from" class="form-input" 
                                       value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="date_to" class="form-label">Tanggal Sampai:</label>
                                <input type="date" id="date_to" name="date_to" class="form-input" 
                                       value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="month" class="form-label">Bulan:</label>
                                <input type="month" id="month" name="month" class="form-input" 
                                       value="<?= htmlspecialchars($_GET['month'] ?? '') ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="id_kategori" class="form-label">Kategori:</label>
                                <select id="id_kategori" name="id_kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id_kategori'] ?>" 
                                                <?= (($_GET['id_kategori'] ?? '') == $category['id_kategori']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['ket_kategori']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="status" class="form-label">Status:</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" <?= (($_GET['status'] ?? '') == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="Proses" <?= (($_GET['status'] ?? '') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                                    <option value="Selesai" <?= (($_GET['status'] ?? '') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-actions">
                            <a href="/admin/aspirations" class="btn btn-outline">Reset Filter</a>
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
                
                <!-- Results Info -->
                <?php if (!empty($aspirations)): ?>
                    <div class="mb-4">
                        <p style="font-size: var(--font-size-sm); color: var(--primary-700); padding: var(--spacing-3); background: rgba(134, 197, 255, 0.05); border-radius: var(--radius-lg); border: 1px solid rgba(134, 197, 255, 0.2);">
                            <?php if (!empty($_GET['search'])): ?>
                                <strong>Hasil pencarian untuk:</strong> "<span style="background: #3d84d6; padding: 2px 6px; border-radius: 4px; font-weight: 600;"><?= htmlspecialchars($_GET['search']) ?></span>" - 
                                Menampilkan <strong><?= count($aspirations) ?></strong> dari <strong><?= $totalCount ?></strong> aspirasi
                            <?php else: ?>
                                Menampilkan <strong><?= count($aspirations) ?></strong> dari <strong><?= $totalCount ?></strong> aspirasi
                            <?php endif; ?>
                        </p>
                    </div>
                <?php elseif (!empty($_GET['search'])): ?>
                    <div class="mb-4">
                        <div style="padding: var(--spacing-4); background: #fef3c7; border: 1px solid #f59e0b; border-radius: var(--radius-lg); text-align: center;">
                            <div style="margin-bottom: var(--spacing-2);">
                                <div class="icon icon-search icon-2xl" style="color: #d97706;"></div>
                            </div>
                            <h3 style="color: #92400e; margin-bottom: var(--spacing-2); font-size: var(--font-size-lg);">Tidak Ada Hasil Ditemukan</h3>
                            <p style="color: #b45309; margin-bottom: var(--spacing-3); font-size: var(--font-size-sm);">
                                Tidak ditemukan aspirasi yang cocok dengan pencarian "<strong style="background: #fef08a; padding: 2px 6px; border-radius: 4px;"><?= htmlspecialchars($_GET['search']) ?></strong>"
                            </p>
                            <div style="display: flex; gap: var(--spacing-2); justify-content: center; flex-wrap: wrap;">
                                <a href="/admin/aspirations" class="btn btn-outline btn-sm">Lihat Semua Aspirasi</a>
                                <button onclick="showSearchTips()" class="btn btn-primary btn-sm">Tips Pencarian</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Data Table Section -->
                <div class="data-section">
                    <div class="data-header">
                        <h2 class="data-title">Daftar Aspirasi</h2>
                        <p class="data-subtitle">
                            <?php if (!empty($aspirations)): ?>
                                Menampilkan <?= count($aspirations) ?> aspirasi
                            <?php else: ?>
                                Tidak ada data yang ditemukan
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <?php if (!empty($aspirations)): ?>
                        <div class="table-responsive">
                            <table class="aspirations-table">
                                <thead>
                                    <tr>
                                        <th class="table-cell-id">ID</th>
                                        <th class="table-cell-date">Tanggal</th>
                                        <th class="table-cell-student">Siswa</th>
                                        <th class="table-cell-category">Kategori</th>
                                        <th class="table-cell-location">Lokasi</th>
                                        <th class="table-cell-status">Status</th>
                                        <th class="table-cell-actions">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($aspirations as $aspiration): ?>
                                        <tr>
                                            <td class="table-cell-id"><?= htmlspecialchars($aspiration['id_pelaporan']) ?></td>
                                            <td class="table-cell-date">
                                                <?php 
                                                if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                                                    echo date('d/m/Y', strtotime($aspiration['created_at'])) . '<br>' . 
                                                         '<span style="font-size: 9px; color: var(--primary-500);">' . 
                                                         date('H:i', strtotime($aspiration['created_at'])) . '</span>';
                                                } elseif (isset($aspiration['submitted_at']) && !empty($aspiration['submitted_at'])) {
                                                    echo date('d/m/Y', strtotime($aspiration['submitted_at'])) . '<br>' . 
                                                         '<span style="font-size: 9px; color: var(--primary-500);">' . 
                                                         date('H:i', strtotime($aspiration['submitted_at'])) . '</span>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td class="table-cell-student">
                                                <div class="table-cell-student-nis"><?= htmlspecialchars($aspiration['nis']) ?></div>
                                                <div class="table-cell-student-class"><?= htmlspecialchars($aspiration['kelas'] ?? 'Tidak ada kelas') ?></div>
                                            </td>
                                            <td class="table-cell-category"><?= htmlspecialchars($aspiration['ket_kategori'] ?? 'Tidak ada kategori') ?></td>
                                            <td class="table-cell-location"><?= htmlspecialchars($aspiration['lokasi']) ?></td>
                                            <td class="table-cell-status">
                                                <span class="status-badge status-<?= strtolower($aspiration['status'] ?? 'belum-diproses') ?>">
                                                    <?= htmlspecialchars($aspiration['status'] ?? 'Belum Diproses') ?>
                                                </span>
                                            </td>
                                            <td class="table-cell-actions">
                                                <div class="action-buttons">
                                                    <a href="/admin/aspiration-detail?id=<?= $aspiration['id_pelaporan'] ?>" 
                                                       class="btn-action btn-detail" title="Lihat Detail">
                                                        <div class="action-icon">
                                                            <div class="icon icon-eye icon-sm"></div>
                                                        </div>
                                                    </a>
                                                    <button onclick="updateStatus(<?= $aspiration['id_pelaporan'] ?>)" 
                                                            class="btn-action btn-status" title="Update Status">
                                                        <div class="action-icon">
                                                            <div class="icon icon-refresh icon-sm"></div>
                                                        </div>
                                                    </button>
                                                    <button onclick="addFeedback(<?= $aspiration['id_pelaporan'] ?>)" 
                                                            class="btn-action btn-feedback" title="Tambah Feedback">
                                                        <div class="action-icon">
                                                            <div class="icon icon-chat icon-sm"></div>
                                                        </div>
                                                    </button>
                                                    <button onclick="deleteAspiration(<?= $aspiration['id_pelaporan'] ?>)" 
                                                            class="btn-action btn-delete" title="Hapus Aspirasi">
                                                        <div class="action-icon">
                                                            <div class="icon icon-trash icon-sm"></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination-wrapper" style="padding: var(--spacing-4); border-top: 1px solid rgba(134, 197, 255, 0.15);">
                                <div class="pagination">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                                           class="pagination-link <?= ($page == $i) ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="padding: var(--spacing-8); text-align: center;">
                            <div style="margin-bottom: var(--spacing-4);">
                                <div class="icon icon-clipboard icon-3xl" style="color: var(--primary-400); opacity: 0.5;"></div>
                            </div>
                            <h3 style="color: var(--primary-700); margin-bottom: var(--spacing-2);">Tidak Ada Data</h3>
                            <p style="color: var(--primary-600);">Tidak ada aspirasi yang ditemukan dengan filter yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, JavaScript ready');
            console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
        });
        
        // Test console log to ensure JavaScript is working
        console.log('JavaScript loaded successfully');
        
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
        
        // Status update function
        function updateStatus(id) {
            console.log('updateStatus called with id:', id);
            
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak tersedia. Status ID: ' + id);
                return;
            }
            
            Swal.fire({
                title: 'Update Status',
                html: `
                    <div style="text-align: center; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-primary">
                            <div class="icon icon-clipboard icon-lg" style="color: white;"></div>
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
                hideClass: {
                    popup: 'swal-fade-out'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silakan pilih status terlebih dahulu'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show professional loading
                    Swal.fire({
                        title: 'Memproses Permintaan',
                        html: `
                            <div style="text-align: center; margin: 0 0 24px 0;">
                                <div class="swal-icon-container swal-icon-primary">
                                    <div class="swal-loading-spinner"></div>
                                </div>
                                <p class="swal-professional-content">
                                    Sedang memperbarui status aspirasi...
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
                                            <div class="icon icon-check icon-lg" style="color: white;"></div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Status aspirasi <strong>#${id}</strong> telah berhasil diperbarui
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
                                            <div class="icon icon-x icon-lg" style="color: white;"></div>
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
        
        // Add feedback function
        function addFeedback(id) {
            console.log('addFeedback called with id:', id);
            
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak tersedia. Feedback ID: ' + id);
                return;
            }
            
            Swal.fire({
                title: 'Tambah Feedback',
                html: `
                    <div style="text-align: center; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-success">
                            <div class="icon icon-chat icon-lg" style="color: white;"></div>
                        </div>
                        <p class="swal-professional-content">
                            Berikan feedback untuk aspirasi <strong>#${id}</strong>
                        </p>
                    </div>
                `,
                input: 'textarea',
                inputPlaceholder: 'Tulis feedback Anda di sini...\n\nContoh:\n• Status sudah ditindaklanjuti\n• Sedang dalam proses perbaikan\n• Telah selesai diperbaiki',
                inputAttributes: {
                    style: 'min-height: 120px;'
                },
                showCancelButton: true,
                confirmButtonText: 'Kirim Feedback',
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
                hideClass: {
                    popup: 'swal-fade-out'
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
                    // Show professional loading
                    Swal.fire({
                        title: 'Mengirim Feedback',
                        html: `
                            <div style="text-align: center; margin: 0 0 24px 0;">
                                <div class="swal-icon-container swal-icon-success">
                                    <div class="swal-loading-spinner"></div>
                                </div>
                                <p class="swal-professional-content">
                                    Sedang mengirim feedback Anda...
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
                    formData.append('feedback', result.value.trim());
                    
                    fetch('/admin/add-feedback', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Feedback Berhasil Dikirim',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-success">
                                            <div class="icon icon-check icon-lg" style="color: white;"></div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Feedback untuk aspirasi <strong>#${id}</strong> telah berhasil dikirim
                                        </p>
                                        <p class="swal-professional-content" style="font-size: 12px; color: #9ca3af;">
                                            Siswa akan menerima notifikasi feedback Anda
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
                                            <div class="icon icon-x icon-lg" style="color: white;"></div>
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

        // Search tips function
        function showSearchTips() {
            Swal.fire({
                title: 'Tips Pencarian',
                html: `
                    <div style="text-align: left; margin: 0 0 24px 0;">
                        <div class="swal-icon-container swal-icon-primary" style="margin: 0 auto 20px;">
                            <div class="icon icon-lightbulb icon-lg" style="color: white;"></div>
                        </div>
                        <div style="font-size: 14px; line-height: 1.6;">
                            <p><strong>Anda dapat mencari berdasarkan:</strong></p>
                            <ul style="margin: 12px 0; padding-left: 20px;">
                                <li>ID Pelaporan (contoh: 12345)</li>
                                <li>NIS Siswa (contoh: 2021001)</li>
                                <li>Kelas (contoh: XII IPA 1)</li>
                                <li>Kategori (contoh: Kerusakan Sarana)</li>
                                <li>Lokasi (contoh: Ruang Kelas)</li>
                                <li>Deskripsi masalah</li>
                                <li>Status (Menunggu, Proses, Selesai)</li>
                            </ul>
                            <p><strong>Tips pencarian:</strong></p>
                            <ul style="margin: 12px 0; padding-left: 20px;">
                                <li>Gunakan kata kunci yang spesifik</li>
                                <li>Coba variasi kata yang berbeda</li>
                                <li>Kombinasikan dengan filter tanggal/kategori</li>
                            </ul>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'swal-professional-popup',
                    title: 'swal-professional-title',
                    confirmButton: 'swal-professional-confirm'
                },
                showClass: {
                    popup: 'swal-fade-in'
                }
            });
        }

        // Highlight search terms in results
        function highlightSearchTerms() {
            const searchTerm = new URLSearchParams(window.location.search).get('search');
            if (!searchTerm) return;
            
            const terms = searchTerm.toLowerCase().split(' ').filter(term => term.length > 2);
            if (terms.length === 0) return;
            
            // Find all text content in table cells
            const tableCells = document.querySelectorAll('.aspirations-table td');
            tableCells.forEach(cell => {
                highlightInElement(cell, terms);
            });
        }

        function highlightInElement(element, terms) {
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            const textNodes = [];
            let node;
            while (node = walker.nextNode()) {
                textNodes.push(node);
            }
            
            textNodes.forEach(textNode => {
                let text = textNode.textContent;
                let hasMatch = false;
                
                terms.forEach(term => {
                    const regex = new RegExp(`(${term})`, 'gi');
                    if (regex.test(text)) {
                        text = text.replace(regex, '<mark style="background: #fef08a; padding: 1px 2px; border-radius: 2px;">$1</mark>');
                        hasMatch = true;
                    }
                });
                
                if (hasMatch) {
                    const span = document.createElement('span');
                    span.innerHTML = text;
                    textNode.parentNode.replaceChild(span, textNode);
                }
            });
        }

        // Initialize highlighting when page loads
        document.addEventListener('DOMContentLoaded', function() {
            highlightSearchTerms();
            
            // Add search input enhancements
            const searchInput = document.getElementById('search');
            if (searchInput) {
                // Add search icon styling
                searchInput.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--primary-600)';
                    this.style.boxShadow = '0 0 0 3px rgba(46, 90, 167, 0.1)';
                });
                
                searchInput.addEventListener('blur', function() {
                    this.style.borderColor = 'rgba(134, 197, 255, 0.3)';
                    this.style.boxShadow = 'none';
                });
                
                // Add enter key support
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        this.form.submit();
                    }
                });
                
                // Add clear button functionality
                if (this.value) {
                    searchInput.style.paddingRight = '80px';
                }
            }
        });
        
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
                            <div class="icon icon-trash icon-lg" style="color: white;"></div>
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
                },
                hideClass: {
                    popup: 'swal-fade-out'
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
                                            <div class="icon icon-check icon-lg" style="color: white;"></div>
                                        </div>
                                        <p class="swal-professional-content">
                                            Aspirasi <strong>#${id}</strong> telah berhasil dihapus dari sistem
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
                                title: 'Gagal Menghapus Aspirasi',
                                html: `
                                    <div style="text-align: center; margin: 0 0 24px 0;">
                                        <div class="swal-icon-container swal-icon-error">
                                            <div class="icon icon-x icon-lg" style="color: white;"></div>
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