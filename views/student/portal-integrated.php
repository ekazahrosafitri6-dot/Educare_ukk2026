<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background: var(--sea-breeze);
            color: white;
            padding: 60px 20px 40px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.95;
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: -20px auto 60px;
            padding: 0 20px;
        }
        
        /* Tab Navigation */
        .tab-nav {
            background: white;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            overflow-x: auto;
        }
        
        .tab-button {
            flex: 1;
            padding: 20px 24px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .tab-button:hover {
            color: var(--primary-900);
            background: #f8fafc;
        }
        
        .tab-button.active {
            color: var(--primary-900);
            border-bottom-color: var(--primary-900);
            background: #f8fafc;
        }
        
        /* Tab Content */
        .tab-content {
            background: white;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            min-height: 600px;
        }
        
        .tab-pane {
            display: none;
            padding: 40px;
        }
        
        .tab-pane.active {
            display: block;
        }
        
        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }
        
        .required {
            color: #ef4444;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background: #ffffff;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-900);
            box-shadow: 0 0 0 3px rgba(46, 90, 167, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        /* Button Styles */
        .btn {
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--primary-900);
            border-color: transparent;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 56, 188, 0.3);
        }
        
        .btn-outline {
            background: white;
            border-color: #94a3b8;
            color: #1e293b;
        }
        
        .btn-outline:hover {
            border-color: var(--primary-900);
            color: var(--primary-900);
            background: #eff6ff;
        }
        
        /* Alert Styles */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 2px solid;
            font-size: 14px;
        }
        
        .alert-success {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }
        
        .alert-error {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }
        
        .alert-info {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1e3a8a;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-menunggu {
            background: #fbbf24;
            color: #78350f;
        }
        
        .status-proses {
            background: #60a5fa;
            color: #1e3a8a;
        }
        
        .status-selesai {
            background: #34d399;
            color: #065f46;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            background: #f8fafc;
            padding: 20px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        
        /* Search Section */
        .search-section {
            background: #f0f9ff;
            border: 2px solid #93c5fd;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
        }
        
        .search-form {
            display: flex;
            gap: 16px;
            align-items: end;
        }
        
        .search-form .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 0;
            bottom: 0;
            width: 3px;
            background:var(--sea-breeze);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-dot {
            position: absolute;
            left: -32px;
            top: 20px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            border: 4px solid #1e40af;
            z-index: 1;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }
        
        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #0f172a;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .tab-button {
                padding: 16px 12px;
                font-size: 14px;
            }
            
            .tab-pane {
                padding: 24px;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .search-form .form-group {
                width: 100%;
            }
        }
        
        /* Loading State */
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #64748b;
        }
        
        .loading.show {
            display: block;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🎓 Portal Siswa EduCare</h1>
        <p>Kelola aspirasi sarana sekolah Anda dalam satu tempat</p>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button class="tab-button active" data-tab="form">
                <i class="bi bi-plus-circle-fill"></i> Ajukan Aspirasi
            </button>
            <button class="tab-button" data-tab="feedback">
                <i class="bi bi-chat-dots-fill"></i> Status & Progress
            </button>
            <button class="tab-button" data-tab="history">
                <i class="bi bi-clock-history"></i> Riwayat Aspirasi
            </button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Form Tab -->
            <div class="tab-pane active" id="form">
                <h2 style="margin-bottom: 24px; color: #0f172a;"><i class="bi bi-plus-circle-fill"></i> Ajukan Aspirasi Baru</h2>
                
                <!-- Success/Error Messages -->
                <div id="form-messages"></div>
                
                <form id="aspirationForm" method="POST" action="/student/submit" novalidate>
                    <div class="form-grid">
                        <!-- Student Information -->
                        <div>
                            <h3 style="margin-bottom: 20px; color: #0f172a;">👤 Informasi Siswa</h3>
                            
                            <div class="form-group">
                                <label for="nis" class="form-label">
                                    NIS <span class="required">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="nis" 
                                    name="nis" 
                                    class="form-input" 
                                    placeholder="Masukkan NIS (maksimal 10 digit)"
                                    maxlength="10"
                                    required
                                >
                                <span class="form-error" id="nis-error"></span>
                            </div>

                            <div class="form-group">
                                <label for="kelas" class="form-label">
                                    Kelas <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="kelas" 
                                    name="kelas" 
                                    class="form-input" 
                                    placeholder="Contoh: XII RPL 1"
                                    maxlength="10"
                                    required
                                >
                                <span class="form-error" id="kelas-error"></span>
                            </div>
                        </div>

                        <!-- Complaint Details -->
                        <div>
                            <h3 style="margin-bottom: 20px; color: #0f172a;"><i class="bi bi-plus-circle-fill"></i> Detail Pengaduan</h3>
                            
                            <div class="form-group">
                                <label for="id_kategori" class="form-label">
                                    Kategori <span class="required">*</span>
                                </label>
                                <select 
                                    id="id_kategori" 
                                    name="id_kategori" 
                                    class="form-select"
                                    required
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category['id_kategori']) ?>">
                                            <?= htmlspecialchars($category['ket_kategori']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-error" id="kategori-error"></span>
                            </div>

                            <div class="form-group">
                                <label for="lokasi" class="form-label">
                                    Lokasi <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="lokasi" 
                                    name="lokasi" 
                                    class="form-input" 
                                    placeholder="Contoh: Ruang Kelas XII RPL 1"
                                    maxlength="50"
                                    required
                                >
                                <span class="form-error" id="lokasi-error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ket" class="form-label">
                            Keterangan <span class="required">*</span>
                        </label>
                        <textarea 
                            id="ket" 
                            name="ket" 
                            class="form-textarea" 
                            placeholder="Jelaskan detail pengaduan Anda (maksimal 50 karakter)"
                            maxlength="50"
                            rows="3"
                            required
                        ></textarea>
                        <span class="form-error" id="ket-error"></span>
                        <span style="font-size: 13px; color: #475569; margin-top: 6px; display: block;">
                            <span id="ket-counter">0</span>/50 karakter
                        </span>
                    </div>

                    <div style="display: flex; gap: 16px; justify-content: flex-end;">
                        <button type="button" class="btn btn-outline" onclick="clearForm()">
                            🗑️ Bersihkan Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            📤 Kirim Aspirasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Status & Progress Tab -->
            <div class="tab-pane" id="feedback">
                <h2 style="margin-bottom: 24px; color: #0f172a;"><i class="bi bi-chat-dots-fill"></i> Status & Progress Aspirasi</h2>
                
                <!-- Search Section -->
                <div class="search-section">
                    <div class="search-form">
                        <div class="form-group">
                            <label for="feedback-nis" class="form-label">Masukkan NIS Anda</label>
                            <input 
                                type="number" 
                                id="feedback-nis" 
                                class="form-input" 
                                placeholder="Contoh: 1234567890"
                                maxlength="10"
                            >
                        </div>
                        <button type="button" class="btn btn-primary" onclick="loadFeedback()">
                            <i class="bi bi-search-heart-fill"></i> Cek Status & Progress
                        </button>
                    </div>
                </div>

                <!-- Feedback Results -->
                <div id="feedback-results">
                    <div class="empty-state">
                        <div class="icon">  <i class="bi bi-search-heart-fill"></i></div>
                        <h3>Masukkan NIS untuk Melihat Status & Progress</h3>
                        <p>Masukkan NIS Anda di atas untuk melihat status, feedback, dan progress aspirasi</p>
                    </div>
                </div>
            </div>

            <!-- History Tab -->
            <div class="tab-pane" id="history">
                <h2 style="margin-bottom: 24px; color: #0f172a;"><i class="bi bi-clock-history"></i> Riwayat Aspirasi</h2>
                
                <!-- Search Section -->
                <div class="search-section">
                    <div class="search-form">
                        <div class="form-group">
                            <label for="history-nis" class="form-label">Masukkan NIS Anda</label>
                            <input 
                                type="number" 
                                id="history-nis" 
                                class="form-input" 
                                placeholder="Contoh: 1234567890"
                                maxlength="10"
                            >
                        </div>
                        <button type="button" class="btn btn-primary" onclick="loadHistory()">
                            <i class="bi bi-clock-history"></i> Lihat Riwayat
                        </button>
                    </div>
                </div>

                <!-- History Results -->
                <div id="history-results">
                    <div class="empty-state">
                        <div class="icon">  <i class="bi bi-clock-history"></i></div>
                        <h3>Masukkan NIS untuk Melihat Riwayat</h3>
                        <p>Masukkan NIS Anda di atas untuk melihat riwayat lengkap aspirasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/student-portal.js"></script>
</body>
</html>