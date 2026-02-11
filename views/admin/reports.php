<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analisis - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/admin-auth-guard.js"></script>
    <style>
        /* Layout Container */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Main Content Wrapper */
        .admin-main-wrapper {
            flex: 1;
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, var(--neutral-50), white);
        }
        
        /* Top Header */
        .admin-top-header {
            background: white;
            border-bottom: 1px solid rgba(134, 197, 255, 0.25);
            padding: var(--spacing-4) var(--spacing-6);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .admin-header-left {
            display: flex;
            align-items: center;
            gap: var(--spacing-4);
        }
        
        .admin-mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(134, 197, 255, 0.1);
            border-radius: var(--radius-lg);
            color: var(--primary-600);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
        }
        
        .admin-mobile-menu-btn:hover {
            background: rgba(134, 197, 255, 0.2);
            color: var(--primary-800);
        }
        
        .admin-page-breadcrumb {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-sm);
            color: var(--primary-600);
            font-weight: 500;
        }
        
        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: var(--spacing-4);
        }
        
        .admin-user-info {
            text-align: right;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: var(--primary-900);
            font-size: var(--font-size-sm);
            margin: 0;
        }
        
        .admin-user-role {
            font-size: var(--font-size-xs);
            color: var(--primary-600);
            margin: 0;
        }
        
        .admin-user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--citrus-zest), var(--warning-600));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        /* Main Content */
        .admin-main-content {
            flex: 1;
            padding: var(--spacing-8) var(--spacing-6);
        }
        
        .admin-page-header {
            margin-bottom: var(--spacing-8);
        }
        
        .admin-page-title {
            font-size: var(--font-size-3xl);
            font-weight: 700;
            color: var(--primary-900);
            margin-bottom: var(--spacing-2);
        }
        
        .admin-page-subtitle {
            color: var(--primary-600);
            font-size: var(--font-size-lg);
            margin: 0;
        }
        

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--spacing-6);
            margin-bottom: var(--spacing-8);
        }
        
        .stat-card {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            padding: var(--spacing-6);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 90, 167, 0.12);
            border-color: rgba(46, 90, 167, 0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-900);
            opacity: 0.8;
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--spacing-4);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            background: var(--primary-900);
        }
        
        .stat-number {
            font-size: var(--font-size-3xl);
            font-weight: 800;
            color: var(--primary-900);
            line-height: 1;
        }
        
        .stat-label {
            font-size: var(--font-size-sm);
            color: var(--primary-600);
            font-weight: 500;
            margin-top: var(--spacing-1);
        }
        
        .stat-change {
            font-size: var(--font-size-xs);
            font-weight: 500;
            margin-top: var(--spacing-2);
            color: var(--primary-700);
        }
        
        /* Report Results */
        .report-results {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .results-header {
            background: linear-gradient(135deg, rgba(253, 252, 248, 0.8), rgba(248, 230, 160, 0.1));
            padding: var(--spacing-6);
            border-bottom: 1px solid rgba(134, 197, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .results-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0;
        }
        
        .export-actions {
            display: flex;
            gap: var(--spacing-2);
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            background: linear-gradient(135deg, rgba(253, 252, 248, 0.8), rgba(248, 230, 160, 0.1));
            padding: var(--spacing-4);
            text-align: left;
            border-bottom: 1px solid rgba(134, 197, 255, 0.2);
            font-size: var(--font-size-xs);
            font-weight: 600;
            color: var(--primary-800);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .table td {
            padding: var(--spacing-4);
            border-bottom: 1px solid rgba(134, 197, 255, 0.15);
            vertical-align: top;
        }
        
        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(253, 252, 248, 0.6), rgba(248, 230, 160, 0.08));
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: var(--spacing-1) var(--spacing-3);
            border-radius: var(--radius-md);
            font-size: var(--font-size-xs);
            font-weight: 500;
            min-width: 70px;
            justify-content: center;
        }
        
        .status-menunggu {
            background: var(--citrus-zest);
            color: white;
        }
        
        .status-proses {
            background: var(--sea-breeze);
            color: var(--amalfi-tile);
        }
        
        .status-selesai {
            background: var(--success-100);
            color: var(--success-600);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: var(--spacing-16);
            color: var(--primary-600);
        }
        
        .empty-icon {
            font-size: 48px;
            margin-bottom: var(--spacing-4);
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-main-wrapper {
                margin-left: 0;
            }
            
            .admin-mobile-menu-btn {
                display: flex;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .admin-main-content {
                padding: var(--spacing-6) var(--spacing-4);
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-page-title {
                font-size: var(--font-size-2xl);
            }
            
            .results-header {
                flex-direction: column;
                gap: var(--spacing-4);
                align-items: stretch;
            }
            
            .export-actions {
                justify-content: stretch;
            }
            
            .export-actions .btn {
                flex: 1;
            }
        }
        
        /* Print Styles */
        @media print {
            /* Hide elements that shouldn't be printed */
            .admin-sidebar,
            .admin-top-header,
            .admin-sidebar-overlay,
            .mobile-menu-btn,
            .export-actions,
            .filter-actions,
            .report-filters,
            .btn {
                display: none !important;
            }
            
            /* Reset layout for print */
            .admin-layout {
                display: block;
            }
            
            .admin-main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .admin-main-content {
                padding: 0 !important;
                margin: 0 !important;
            }
            
            /* Print header */
            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 15px;
            }
            
            .print-title {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 10px;
                color: #000 !important;
            }
            
            .print-subtitle {
                font-size: 16px;
                color: #666 !important;
                margin-bottom: 5px;
            }
            
            .print-date {
                font-size: 14px;
                color: #888 !important;
            }
            
            /* Statistics for print - HIDE COMPLETELY */
            .stats-grid {
                display: none !important;
            }
            
            /* Table styles for print */
            .report-results {
                border: none !important;
                box-shadow: none !important;
                margin-top: 0 !important;
            }
            
            .results-header {
                background: none !important;
                border-bottom: 2px solid #000 !important;
                padding: 10px 0 !important;
            }
            
            .results-title {
                color: #000 !important;
                font-size: 18px !important;
                font-weight: bold !important;
            }
            
            .table {
                border-collapse: collapse !important;
                width: 100% !important;
                font-size: 12px !important;
                margin-top: 10px !important;
            }
            
            .table th {
                background: #f0f0f0 !important;
                border: 1px solid #000 !important;
                padding: 8px !important;
                font-weight: bold !important;
                color: #000 !important;
                text-align: center !important;
            }
            
            .table td {
                border: 1px solid #000 !important;
                padding: 6px !important;
                color: #000 !important;
                vertical-align: top !important;
                word-wrap: break-word !important;
                white-space: normal !important;
            }
            
            /* Hide Status column and Feedback column when printing */
            .table th:nth-child(7),
            .table td:nth-child(7),
            .table th:nth-child(8),
            .table td:nth-child(8) {
                display: none !important;
            }
            
            .status-badge {
                border: 1px solid #000 !important;
                padding: 2px 6px !important;
                font-weight: bold !important;
                background: none !important;
            }
            
            .status-menunggu {
                color: #000 !important;
            }
            
            .status-proses {
                color: #000 !important;
            }
            
            .status-selesai {
                color: #000 !important;
            }
            
            /* Page breaks - Keep table on first page */
            .report-results {
                page-break-inside: avoid;
                page-break-before: avoid;
            }
            
            .table thead {
                display: table-header-group;
            }
            
            .table tbody tr {
                page-break-inside: avoid;
            }
            
            /* Ensure content fits on first page */
            .admin-main-content {
                page-break-after: avoid;
            }
            
            .print-header {
                page-break-after: avoid;
            }
            
            /* Print footer */
            .print-footer {
                display: block !important;
                margin-top: 20px;
                padding-top: 15px;
                border-top: 1px solid #000;
                text-align: center;
                font-size: 10px;
                color: #666 !important;
                page-break-inside: avoid;
            }
            
            /* Force black text for better printing */
            * {
                color: #000 !important;
                background: transparent !important;
            }
            
            .table th {
                background: #f0f0f0 !important;
            }
            
            .stat-card {
                background: #f9f9f9 !important;
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
                            <a href="/admin/aspirations" class="admin-nav-link">
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
                            <a href="/admin/reports" class="admin-nav-link active">
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
                        <?= strtoupper(substr($username ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="admin-user-profile-info">
                        <p class="admin-user-profile-name"><?= htmlspecialchars($username ?? 'Administrator') ?></p>
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
                        <span>Laporan & Analisis</span>
                    </div>
                </div>
                
                <div class="admin-user-menu">
                    <div class="admin-user-info">
                        <p class="admin-user-name"><?= htmlspecialchars($username ?? 'Administrator') ?></p>
                        <p class="admin-user-role">Administrator</p>
                    </div>
                    <div class="admin-user-avatar">
                        <?= strtoupper(substr($username ?? 'A', 0, 1)) ?>
                    </div>
                    <a href="/admin/logout" class="btn btn-outline btn-sm">Logout</a>
                </div>
            </header>
    
            <!-- Main Content -->
            <main class="admin-main-content">
                <!-- Print Header (hidden by default, shown only when printing) -->
                <div class="print-header" style="display: none;">
                    <div class="print-title">LAPORAN ASPIRASI SISWA</div>
                    <div class="print-subtitle">EduCare - Sistem Pengaduan Fasilitas Sekolah</div>
                    <div class="print-date">Dicetak pada: <?= date('d F Y, H:i:s') ?></div>
                </div>
                
                <!-- Page Header -->
                <div class="admin-page-header">
                    <h1 class="admin-page-title">Laporan & Analisis</h1>
                    <p class="admin-page-subtitle">Analisis data aspirasi siswa dengan berbagai filter dan kriteria</p>
                </div>
                
                <!-- Report Filters -->
                <div class="report-filters" style="background: white; border: 1px solid rgba(134, 197, 255, 0.25); border-radius: var(--radius-xl); padding: var(--spacing-6); margin-bottom: var(--spacing-8); box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);">
                    <form method="GET" action="/admin/reports" id="reportFilterForm">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-4); margin-bottom: var(--spacing-4);">
                            <!-- Filter Type Selection -->
                            <div>
                                <label for="filter_type" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Jenis Filter</label>
                                <select name="filter_type" id="filter_type" class="form-control" onchange="toggleFilterInputs()" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                                    <option value="">Pilih Jenis Filter</option>
                                    <option value="daily" <?= (isset($_GET['filter_type']) && $_GET['filter_type'] === 'daily') ? 'selected' : '' ?>>Per Hari</option>
                                    <option value="monthly" <?= (isset($_GET['filter_type']) && $_GET['filter_type'] === 'monthly') ? 'selected' : '' ?>>Per Bulan</option>
                                    <option value="range" <?= (isset($_GET['filter_type']) && $_GET['filter_type'] === 'range') ? 'selected' : '' ?>>Rentang Tanggal</option>
                                </select>
                            </div>
                            
                            <!-- Daily Filter -->
                            <div id="daily_filter" style="display: none;">
                                <label for="daily_date" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Pilih Tanggal</label>
                                <input type="date" name="daily_date" id="daily_date" class="form-control" value="<?= $_GET['daily_date'] ?? '' ?>" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                            </div>
                            
                            <!-- Monthly Filter -->
                            <div id="monthly_filter" style="display: none;">
                                <label for="monthly_date" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Pilih Bulan</label>
                                <input type="month" name="monthly_date" id="monthly_date" class="form-control" value="<?= $_GET['monthly_date'] ?? '' ?>" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                            </div>
                            
                            <!-- Range Filter -->
                            <div id="range_from_filter" style="display: none;">
                                <label for="date_from" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Tanggal Dari</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="<?= $_GET['date_from'] ?? '' ?>" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                            </div>
                            
                            <div id="range_to_filter" style="display: none;">
                                <label for="date_to" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Tanggal Sampai</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="<?= $_GET['date_to'] ?? '' ?>" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <label for="id_kategori" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Kategori</label>
                                <select name="id_kategori" id="id_kategori" class="form-control" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                                    <option value="">Semua Kategori</option>
                                    <?php if (isset($categories) && is_array($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id_kategori'] ?>" <?= (isset($_GET['id_kategori']) && $_GET['id_kategori'] == $category['id_kategori']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category['ket_kategori']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <!-- Status Filter -->
                            <div>
                                <label for="status" style="display: block; font-weight: 600; color: var(--primary-800); margin-bottom: var(--spacing-2); font-size: var(--font-size-sm);">Status</label>
                                <select name="status" id="status" class="form-control" style="width: 100%; padding: var(--spacing-3); border: 1px solid rgba(134, 197, 255, 0.3); border-radius: var(--radius-md); font-size: var(--font-size-sm);">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu" <?= (isset($_GET['status']) && $_GET['status'] === 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="proses" <?= (isset($_GET['status']) && $_GET['status'] === 'proses') ? 'selected' : '' ?>>Dalam Proses</option>
                                    <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] === 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Filter Actions -->
                        <div class="filter-actions" style="display: flex; gap: var(--spacing-3); justify-content: flex-end;">
                            <button type="button" class="btn btn-outline btn-sm" onclick="resetFilters()">
                                🔄 Reset Filter
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                🔍 Generate Laporan
                            </button>
                        </div>
                    </form>
                </div>

           
            <?php if (isset($reportData)): ?>
                <!-- Statistics Summary -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $reportData['summary']['total'] ?? 0 ?></div>
                                <div class="stat-label">Total Aspirasi</div>
                            </div>
                            <div class="stat-icon total">
                                <div class="icon icon-chart-bar icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change neutral">
                            Dalam periode yang dipilih
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $reportData['summary']['menunggu'] ?? 0 ?></div>
                                <div class="stat-label">Menunggu</div>
                            </div>
                            <div class="stat-icon pending">
                                <div class="icon icon-clock icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change neutral">
                            <?= ($reportData['summary']['total'] ?? 0) > 0 ? round((($reportData['summary']['menunggu'] ?? 0) / ($reportData['summary']['total'] ?? 1)) * 100, 1) : 0 ?>% dari total
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $reportData['summary']['proses'] ?? 0 ?></div>
                                <div class="stat-label">Dalam Proses</div>
                            </div>
                            <div class="stat-icon progress">
                                <div class="icon icon-refresh icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change neutral">
                            <?= ($reportData['summary']['total'] ?? 0) > 0 ? round((($reportData['summary']['proses'] ?? 0) / ($reportData['summary']['total'] ?? 1)) * 100, 1) : 0 ?>% dari total
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $reportData['summary']['selesai'] ?? 0 ?></div>
                                <div class="stat-label">Selesai</div>
                            </div>
                            <div class="stat-icon completed">
                                <div class="icon icon-check icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change positive">
                            <?= ($reportData['summary']['total'] ?? 0) > 0 ? round((($reportData['summary']['selesai'] ?? 0) / ($reportData['summary']['total'] ?? 1)) * 100, 1) : 0 ?>% dari total
                        </div>
                    </div>
                </div>
                
                <!-- Report Results -->
                <div class="report-results">
                    <div class="results-header">
                        <h3 class="results-title">Hasil Laporan (<?= count($reportData['details'] ?? []) ?> aspirasi)</h3>
                        <div class="export-actions">
                            <button type="button" class="btn btn-success btn-sm" onclick="printReport()">
                                🖨️ Cetak Laporan
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="exportToExcel()">
                                📋 Export Excel
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="exportToPDF()">
                                📄 Export PDF
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table" id="reportTable">
                            <thead>
                                <tr>
                                    <th>ID Pelaporan</th>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($reportData['details'])): ?>
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <div class="icon icon-document-report icon-2xl"></div>
                                                </div>
                                                <p>Tidak ada data yang sesuai dengan filter yang dipilih</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($reportData['details'] as $aspiration): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($aspiration['id_pelaporan']) ?></td>
                                            <td>
                                                <?php 
                                                if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                                                    echo date('d/m/Y H:i', strtotime($aspiration['created_at']));
                                                } elseif (isset($aspiration['submitted_at']) && !empty($aspiration['submitted_at'])) {
                                                    echo date('d/m/Y H:i', strtotime($aspiration['submitted_at']));
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= htmlspecialchars($aspiration['nis']) ?></strong><br>
                                                    <small><?= htmlspecialchars($aspiration['kelas'] ?? '-') ?></small>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($aspiration['ket_kategori']) ?></td>
                                            <td><?= htmlspecialchars($aspiration['lokasi']) ?></td>
                                            <td>
                                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($aspiration['ket']) ?>">
                                                    <?= htmlspecialchars($aspiration['ket']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($aspiration['status']) ?>">
                                                    <?= htmlspecialchars($aspiration['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($aspiration['feedback'])): ?>
                                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($aspiration['feedback']) ?>">
                                                        <?= htmlspecialchars($aspiration['feedback']) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span style="color: var(--secondary-400);">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Print Footer (hidden by default, shown only when printing) -->
                <div class="print-footer" style="display: none;">
                    <p>Laporan ini digenerate secara otomatis oleh sistem EduCare</p>
                    <p>© <?= date('Y') ?> EduCare - Sistem Pengaduan Fasilitas Sekolah</p>
                </div>
            <?php else: ?>
                <!-- Initial State -->
                <div class="report-results">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <div class="icon icon-document-report icon-2xl"></div>
                        </div>
                        <h3>Pilih Filter untuk Generate Laporan</h3>
                        <p>Gunakan filter di atas untuk menghasilkan laporan aspirasi sesuai kriteria yang diinginkan</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
        </div>
    </div>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        });
        
        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });
        
        // Print Report function
        function printReport() {
            // Check if there's data to print
            const reportTable = document.getElementById('reportTable');
            const tableBody = reportTable.querySelector('tbody');
            const hasData = tableBody && tableBody.children.length > 0 && 
                           !tableBody.querySelector('.empty-state');
            
            if (!hasData) {
                alert('Tidak ada data untuk dicetak. Silakan generate laporan terlebih dahulu.');
                return;
            }
            
            // Show confirmation dialog
            if (!confirm('Apakah Anda yakin ingin mencetak laporan ini?')) {
                return;
            }
            
            // Trigger print dialog
            window.print();
        }
        
        // Reset filters function
        function resetFilters() {
            // Redirect to clean URL without parameters
            window.location.href = '/admin/reports';
        }
        
        // Export to Excel function
        function exportToExcel() {
            // Create a temporary form for Excel export
            const excelForm = document.createElement('form');
            excelForm.method = 'POST';
            excelForm.action = '/admin/reports/export-excel';
            excelForm.style.display = 'none';
            
            // Submit form to trigger Excel download
            document.body.appendChild(excelForm);
            excelForm.submit();
            document.body.removeChild(excelForm);
        }
        
        // Export to PDF function
        function exportToPDF() {
            // Get current filter values
            const filterType = document.getElementById('filter_type').value;
            const dailyDate = document.getElementById('daily_date').value;
            const monthlyDate = document.getElementById('monthly_date').value;
            const dateFrom = document.getElementById('date_from').value;
            const dateTo = document.getElementById('date_to').value;
            const kategori = document.getElementById('id_kategori').value;
            const status = document.getElementById('status').value;
            
            // Create a temporary form for PDF export
            const pdfForm = document.createElement('form');
            pdfForm.method = 'POST';
            pdfForm.action = '/admin/reports/export-pdf';
            pdfForm.style.display = 'none';
            
            // Add filter parameters to form
            if (filterType) {
                const filterTypeInput = document.createElement('input');
                filterTypeInput.type = 'hidden';
                filterTypeInput.name = 'filter_type';
                filterTypeInput.value = filterType;
                pdfForm.appendChild(filterTypeInput);
            }
            
            if (dailyDate) {
                const dailyDateInput = document.createElement('input');
                dailyDateInput.type = 'hidden';
                dailyDateInput.name = 'daily_date';
                dailyDateInput.value = dailyDate;
                pdfForm.appendChild(dailyDateInput);
            }
            
            if (monthlyDate) {
                const monthlyDateInput = document.createElement('input');
                monthlyDateInput.type = 'hidden';
                monthlyDateInput.name = 'monthly_date';
                monthlyDateInput.value = monthlyDate;
                pdfForm.appendChild(monthlyDateInput);
            }
            
            if (dateFrom) {
                const dateFromInput = document.createElement('input');
                dateFromInput.type = 'hidden';
                dateFromInput.name = 'date_from';
                dateFromInput.value = dateFrom;
                pdfForm.appendChild(dateFromInput);
            }
            
            if (dateTo) {
                const dateToInput = document.createElement('input');
                dateToInput.type = 'hidden';
                dateToInput.name = 'date_to';
                dateToInput.value = dateTo;
                pdfForm.appendChild(dateToInput);
            }
            
            if (kategori) {
                const kategoriInput = document.createElement('input');
                kategoriInput.type = 'hidden';
                kategoriInput.name = 'id_kategori';
                kategoriInput.value = kategori;
                pdfForm.appendChild(kategoriInput);
            }
            
            if (status) {
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                pdfForm.appendChild(statusInput);
            }
            
            // Submit form to trigger PDF download
            document.body.appendChild(pdfForm);
            pdfForm.submit();
            document.body.removeChild(pdfForm);
        }
        
        // Toggle filter inputs based on filter type selection
        function toggleFilterInputs() {
            const filterType = document.getElementById('filter_type').value;
            
            // Hide all filter inputs first
            document.getElementById('daily_filter').style.display = 'none';
            document.getElementById('monthly_filter').style.display = 'none';
            document.getElementById('range_from_filter').style.display = 'none';
            document.getElementById('range_to_filter').style.display = 'none';
            
            // Show relevant filter inputs based on selection
            if (filterType === 'daily') {
                document.getElementById('daily_filter').style.display = 'block';
            } else if (filterType === 'monthly') {
                document.getElementById('monthly_filter').style.display = 'block';
            } else if (filterType === 'range') {
                document.getElementById('range_from_filter').style.display = 'block';
                document.getElementById('range_to_filter').style.display = 'block';
            }
        }
        
        // Initialize filter display on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleFilterInputs();
        });

    </script>
</body>
</html>