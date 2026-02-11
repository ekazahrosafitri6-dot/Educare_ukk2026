<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Aspirasi Siswa - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        
        .page-header {
            background: var(  --primary-500);
            color: white;
            padding: 100px 20px 60px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            color: white;
        }
        
        .page-header p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
            color: var(--citrus-zes);
        }
        
        .form-container {
            max-width: 1200px;
            margin: -40px auto 60px;
            padding: 0 20px;
        }
        
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
        
        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-section.left {
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
            border-right: 2px solid #93c5fd;
        }
        
        .form-section.right {
            background: white;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-icon {
            width: 42px;
            height: 42px;
            background:var(--primary-500);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .form-group {
            margin-bottom: 24px;
            color:black;
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
        
        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #64748b;
            opacity: 1;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }
        
        .char-counter {
            font-size: 13px;
            color: #475569;
            margin-top: 6px;
            display: block;
        }
        
        .form-actions {
            grid-column: 1 / -1;
            padding: 30px 40px;
            background: #ffffff;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        
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
        
        .btn-outline {
            background: white;
            border-color: #94a3b8;
            color: #1e293b;
        }
        
        .btn-outline:hover {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
        }
        
        .btn-primary {
            background: var( --primary-500);
            border-color: transparent;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var( --primary-400);
        }
        
        .info-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-top: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .info-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            padding: 10px 0;
            color: #334155;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .info-list li::before {
            content: '✓';
            color: #10b981;
            font-weight: bold;
            font-size: 16px;
        }
        
        @media (max-width: 968px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-section.left {
                border-right: none;
                border-bottom: 2px solid #93c5fd;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 640px) {
            .page-header {
                padding: 80px 20px 40px;
            }
            
            .page-header h1 {
                font-size: 28px;
            }
            
            .form-section {
                padding: 24px;
            }
            
            .form-actions {
                padding: 20px 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="bi bi-journal-text"></i> Form Aspirasi Sarana Sekolah</h1>
        <p>Sampaikan aspirasi dan pengaduan terkait sarana dan prasarana sekolah</p>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <!-- Success Message -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <strong>✓ Berhasil!</strong> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <strong>⚠ Perhatian!</strong><br>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="form-card">
            <form id="aspirationForm" action="/student/submit" method="POST" novalidate>
                <div class="form-grid">
                    <!-- Left Section: Student Information -->
                    <div class="form-section left">
                        <div class="section-title">
                            <div class="section-icon"><i class="bi bi-person-lines-fill"></i></div>
                            Informasi Siswa
                        </div>
                        
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
                                max="9999999999"
                                min="1"
                                value="<?= htmlspecialchars($oldInput['nis'] ?? '') ?>"
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
                                value="<?= htmlspecialchars($oldInput['kelas'] ?? '') ?>"
                                required
                            >
                            <span class="form-error" id="kelas-error"></span>
                        </div>
                    </div>

                    <!-- Right Section: Complaint Details -->
                    <div class="form-section right">
                        <div class="section-title">
                            <div class="section-icon"><i class="bi bi-clipboard-data"></i></div>
                            Detail Pengaduan
                        </div>
                        
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
                                    <option 
                                        value="<?= htmlspecialchars($category['id_kategori']) ?>"
                                        <?= (isset($oldInput['id_kategori']) && $oldInput['id_kategori'] == $category['id_kategori']) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($category['ket_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="form-error" id="kategori-error"></span>
                        </div>

                        <div class="form-group">
                            <label for="id_lokasi" class="form-label">
                                Lokasi <span class="required">*</span>
                            </label>
                            <select 
                                id="id_lokasi" 
                                name="id_lokasi" 
                                class="form-select"
                                required
                            >
                                <option value="">-- Pilih Lokasi --</option>
                                <?php foreach ($locations as $location): ?>
                                    <option 
                                        value="<?= htmlspecialchars($location['id_lokasi']) ?>"
                                        <?= (isset($oldInput['id_lokasi']) && $oldInput['id_lokasi'] == $location['id_lokasi']) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($location['nama_lokasi']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="form-error" id="lokasi-error"></span>
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
                            ><?= htmlspecialchars($oldInput['ket'] ?? '') ?></textarea>
                            <span class="form-error" id="ket-error"></span>
                            <span class="char-counter">
                                <span id="ket-counter">0</span>/50 karakter
                            </span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="/student" class="btn btn-outline">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Kirim Aspirasi →
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="info-card">
            <h3><i class="bi bi-info-circle"></i> Informasi Penting</h3>
            <ul class="info-list">
                <li>Semua field yang bertanda <span class="required">*</span> wajib diisi</li>
                <li>Pastikan NIS dan kelas yang Anda masukkan benar</li>
                <li>Jelaskan pengaduan dengan jelas dan spesifik</li>
                <li>Anda dapat melihat feedback di menu "Lihat Feedback"</li>
            </ul>
        </div>
    </div>

    <script>
        // Client-side validation
        const form = document.getElementById('aspirationForm');
        const nisInput = document.getElementById('nis');
        const kelasInput = document.getElementById('kelas');
        const kategoriSelect = document.getElementById('id_kategori');
        const lokasiSelect = document.getElementById('id_lokasi');
        const ketTextarea = document.getElementById('ket');
        const ketCounter = document.getElementById('ket-counter');

        // Character counter for keterangan
        ketTextarea.addEventListener('input', function() {
            const length = this.value.length;
            ketCounter.textContent = length;
            
            if (length >= 50) {
                ketCounter.parentElement.style.color = '#ef4444';
            } else {
                ketCounter.parentElement.style.color = '#64748b';
            }
        });

        // Initialize counter
        ketCounter.textContent = ketTextarea.value.length;

        // Form validation
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default first
            
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(el => {
                el.style.borderColor = '#cbd5e1';
            });

            // Validate NIS
            const nis = nisInput.value.trim();
            if (!nis) {
                showError('nis', 'NIS harus diisi');
                isValid = false;
            } else if (isNaN(nis) || parseInt(nis) <= 0) {
                showError('nis', 'NIS harus berupa angka positif');
                isValid = false;
            } else if (nis.length > 10) {
                showError('nis', 'NIS maksimal 10 digit');
                isValid = false;
            }

            // Validate Kelas
            const kelas = kelasInput.value.trim();
            if (!kelas) {
                showError('kelas', 'Kelas harus diisi');
                isValid = false;
            } else if (kelas.length > 10) {
                showError('kelas', 'Kelas maksimal 10 karakter');
                isValid = false;
            }

            // Validate Kategori
            if (!kategoriSelect.value) {
                showError('kategori', 'Kategori harus dipilih');
                isValid = false;
            }

            // Validate Lokasi
            if (!lokasiSelect.value) {
                showError('lokasi', 'Lokasi harus dipilih');
                isValid = false;
            }

            // Validate Keterangan
            const ket = ketTextarea.value.trim();
            if (!ket) {
                showError('ket', 'Keterangan harus diisi');
                isValid = false;
            } else if (ket.length > 50) {
                showError('ket', 'Keterangan maksimal 50 karakter');
                isValid = false;
            }

            if (!isValid) {
                // Show validation error with SweetAlert
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Mohon periksa dan lengkapi semua field yang diperlukan',
                    icon: 'error',
                    confirmButtonColor: 'var(--primary-900)'
                });
                
                // Scroll to first error
                const firstError = document.querySelector('.form-error:not(:empty)');
                if (firstError) {
                    firstError.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: 'Apakah Anda yakin ingin mengirim aspirasi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim Aspirasi',
                cancelButtonText: 'Batal',
                confirmButtonColor: 'var(--primary-900)',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Mengirim Aspirasi...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form
                    form.submit();
                }
            });
        });

        function showError(fieldId, message) {
            const errorElement = document.getElementById(fieldId + '-error');
            const inputElement = document.getElementById(fieldId);
            
            if (errorElement) {
                errorElement.textContent = message;
            }
            
            if (inputElement) {
                inputElement.style.borderColor = '#ef4444';
            }
        }

        // Real-time validation feedback
        [nisInput, kelasInput, ketTextarea].forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.style.borderColor = '#10b981';
                }
            });
            
            input.addEventListener('focus', function() {
                this.style.borderColor = '#2563eb';
            });
        });

        [kategoriSelect, lokasiSelect].forEach(select => {
            select.addEventListener('change', function() {
                if (this.value) {
                    this.style.borderColor = '#10b981';
                }
            });
            
            select.addEventListener('focus', function() {
                this.style.borderColor = '#2563eb';
            });
        });
    </script>
</body>
</html>
