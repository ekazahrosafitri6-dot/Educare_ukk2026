<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/admin-auth-guard.js"></script>
    <style>
        /* Dashboard specific styles */
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
            background: var( --primary-900);
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
        }
        
        .stat-icon.total {
            background: var( --primary-900);
        }
        
        .stat-icon.pending {
            background: var( --primary-900);
        }
        
        .stat-icon.progress {
            background:  var( --primary-900);
        }
        
        .stat-icon.completed {
            background: var( --primary-900);
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
            color: var(--primary-900);
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            padding: var(--spacing-8);
            margin-bottom: var(--spacing-8);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .section-title {
            font-size: var(--font-size-xl);
            font-weight: 600;
            color: var(--primary-900);
            margin-bottom: var(--spacing-6);
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-4);
        }
        
        .action-card {
            display: flex;
            align-items: center;
            gap: var(--spacing-4);
            padding: var(--spacing-5);
            border: 1px solid rgba(134, 197, 255, 0.2);
            border-radius: var(--radius-lg);
            text-decoration: none;
            transition: all var(--transition-fast);
            background: rgba(253, 252, 248, 0.3);
        }
        
        .action-card:hover {
            border-color: rgba(46, 90, 167, 0.3);
            background: rgba(134, 197, 255, 0.08);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(46, 90, 167, 0.1);
        }
        
        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }
        
        .action-icon.primary {
            background:  var( --primary-900);
        }
        
        .action-content h4 {
            font-size: var(--font-size-sm);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0 0 var(--spacing-1) 0;
        }
        
        .action-content p {
            font-size: var(--font-size-xs);
            color: var(--primary-600);
            margin: 0;
        }
        
        /* System Info */
        .system-info {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            padding: var(--spacing-6);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-4);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-3);
            background: rgba(134, 197, 255, 0.05);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(134, 197, 255, 0.1);
        }
        
        .info-label {
            font-size: var(--font-size-sm);
            font-weight: 500;
            color: var(--primary-700);
        }
        
        .info-value {
            font-size: var(--font-size-sm);
            color: var(--primary-600);
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-1);
            font-size: var(--font-size-xs);
            font-weight: 500;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success-500);
        }
        
        /* Charts Section */
        .charts-section {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            padding: var(--spacing-8);
            margin-bottom: var(--spacing-8);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-8);
            margin-top: var(--spacing-6);
        }
        
        .chart-container {
            background: rgba(253, 252, 248, 0.3);
            border: 1px solid rgba(134, 197, 255, 0.15);
            border-radius: var(--radius-lg);
            padding: var(--spacing-6);
            position: relative;
        }
        
        .chart-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary-900);
            margin-bottom: var(--spacing-4);
            text-align: center;
        }
        
        .chart-canvas {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .chart-legend {
            display: flex;
            justify-content: center;
            gap: var(--spacing-4);
            margin-top: var(--spacing-4);
            flex-wrap: wrap;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-xs);
            color: var(--primary-700);
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-canvas {
                height: 250px;
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
                        <h1> Admin Panel</h1>
                    </div>
                </a>
            </div>
            
            <!-- Sidebar Navigation -->
            <nav class="admin-sidebar-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Menu Utama</div>
                    <ul class="admin-nav-menu">
                        <li class="admin-nav-item">
                            <a href="/admin/dashboard" class="admin-nav-link active">
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
                        <span>Dashboard</span>
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
                    <h1 class="admin-page-title">Selamat datang, <?= htmlspecialchars($username) ?>!</h1>
                    <p class="admin-page-subtitle">Kelola aspirasi dan pengaduan siswa dengan mudah melalui dashboard yang komprehensif ini.</p>
                </div>
                
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $statistics['total'] ?></div>
                                <div class="stat-label">Total Aspirasi</div>
                            </div>
                            <div class="stat-icon total">
                                <div class="icon icon-chart-bar icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change">
                            Semua aspirasi yang masuk
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $statistics['menunggu'] ?></div>
                                <div class="stat-label">Menunggu Review</div>
                            </div>
                            <div class="stat-icon pending">
                                <div class="icon icon-clock icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change">
                            Perlu ditindaklanjuti
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $statistics['proses'] ?></div>
                                <div class="stat-label">Dalam Proses</div>
                            </div>
                            <div class="stat-icon progress">
                                <div class="icon icon-refresh icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change">
                            Sedang dikerjakan
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-number"><?= $statistics['selesai'] ?></div>
                                <div class="stat-label">Selesai</div>
                            </div>
                            <div class="stat-icon completed">
                                <div class="icon icon-check icon-lg"></div>
                            </div>
                        </div>
                        <div class="stat-change">
                            Berhasil diselesaikan
                        </div>
                    </div>
                </div>
                
                <!-- Interactive Charts Section -->
                <div class="charts-section">
                    <h3 class="section-title">Analisis Data Aspirasi</h3>
                    <div class="charts-grid">
                        <!-- Status Distribution Chart -->
                        <div class="chart-container">
                            <h4 class="chart-title">Distribusi Status Aspirasi</h4>
                            <div class="chart-canvas">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Status Count Chart -->
                        <div class="chart-container">
                            <h4 class="chart-title">Jumlah Aspirasi per Status</h4>
                            <div class="chart-canvas">
                                <canvas id="statusCountChart"></canvas>
                            </div>
                            <div style="margin-top: 10px; text-align: center; font-size: 12px; color: #6b7280;">
                                Klik pada bar untuk melihat detail
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h3 class="section-title">Menu Utama</h3>
                    <div class="actions-grid">
                        <a href="/admin/aspirations" class="action-card">
                            <div class="action-icon primary">
                                <div class="icon icon-clipboard icon-lg"></div>
                            </div>
                            <div class="action-content">
                                <h4>Kelola Aspirasi</h4>
                                <p>Lihat, filter, dan kelola semua aspirasi siswa</p>
                            </div>
                        </a>
                        
                        <a href="/admin/reports" class="action-card">
                            <div class="action-icon primary">
                                <div class="icon icon-document-report icon-lg"></div>
                            </div>
                            <div class="action-content">
                                <h4>Laporan & Analisis</h4>
                                <p>Buat laporan dan analisis data aspirasi</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- System Information -->
                <div class="system-info">
                    <h3 class="section-title">Informasi Sistem</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Status Sistem</span>
                            <span class="status-indicator">
                                <span class="status-dot"></span>
                                Berjalan Normal
                            </span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Waktu Login</span>
                            <span class="info-value"><?= date('d/m/Y H:i:s') ?></span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Versi Sistem</span>
                            <span class="info-value">EduCare v1.0.0</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Database</span>
                            <span class="status-indicator">
                                <span class="status-dot"></span>
                                Terhubung
                            </span>
                        </div>
                    </div>
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
        
        // Chart.js Configuration
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#374151';
        
        // Status Distribution Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu Review', 'Dalam Proses', 'Selesai'],
                datasets: [{
                    data: [<?= $statistics['menunggu'] ?>, <?= $statistics['proses'] ?>, <?= $statistics['selesai'] ?>],
                    backgroundColor: [
                        '#f59e0b', // Warning color for pending
                        '#3b82f6', // Primary color for in progress
                        '#10b981'  // Success color for completed
                    ],
                    borderColor: [
                        '#d97706',
                        '#2563eb',
                        '#059669'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 1000
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const label = this.data.labels[index];
                        
                        // Navigate to filtered aspirations page
                        const statusMap = {
                            'Menunggu Review': 'Menunggu',
                            'Dalam Proses': 'Proses',
                            'Selesai': 'Selesai'
                        };
                        
                        if (statusMap[label]) {
                            window.location.href = `/admin/aspirations?status=${statusMap[label]}`;
                        }
                    }
                },
                onHover: function(event, elements) {
                    event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
        
        // Status Count Bar Chart
        const statusCountCtx = document.getElementById('statusCountChart').getContext('2d');
        
        // Simple Status Count Bar Chart Data
        
        const statusCountChart = new Chart(statusCountCtx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Menunggu Review', 'Dalam Proses', 'Selesai'],
                datasets: [{
                    label: 'Jumlah Aspirasi',
                    data: [<?= $statistics['total'] ?>, <?= $statistics['menunggu'] ?>, <?= $statistics['proses'] ?>, <?= $statistics['selesai'] ?>],
                    backgroundColor: [
                        '#2563eb', // Primary blue for total
                        '#f59e0b', // Warning color for pending
                        '#3b82f6', // Primary color for in progress
                        '#10b981'  // Success color for completed
                    ],
                    borderColor: [
                        '#1d4ed8',
                        '#d97706',
                        '#2563eb',
                        '#059669'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const total = <?= $statistics['total'] ?>;
                                const percentage = total > 0 ? ((context.parsed.y / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + context.parsed.y + ' aspirasi (' + percentage + '%)';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.2)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            stepSize: 1
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const label = this.data.labels[index];
                        
                        // Navigate to filtered aspirations page
                        const statusMap = {
                            'Total': '',
                            'Menunggu Review': 'Menunggu',
                            'Dalam Proses': 'Proses',
                            'Selesai': 'Selesai'
                        };
                        
                        if (statusMap.hasOwnProperty(label)) {
                            const status = statusMap[label];
                            const url = status ? `/admin/aspirations?status=${status}` : '/admin/aspirations';
                            window.location.href = url;
                        }
                    }
                },
                onHover: function(event, elements) {
                    event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
    </script>
</body>
</html>