<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lokasi - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/admin-auth-guard.js"></script>
    <style>
        /* Page-specific styles only */
        /* Content Cards */
        .content-card {
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.25);
            border-radius: var(--radius-xl);
            padding: var(--spacing-6);
            margin-bottom: var(--spacing-6);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.06);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-4);
            padding-bottom: var(--spacing-4);
            border-bottom: 1px solid rgba(134, 197, 255, 0.15);
        }
        
        .card-title {
            font-size: var(--font-size-xl);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0;
        }
        
        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: var(--spacing-6);
        }
        
        .form-section {
            background: rgba(134, 197, 255, 0.03);
            border: 1px solid rgba(134, 197, 255, 0.15);
            border-radius: var(--radius-lg);
            padding: var(--spacing-4);
        }
        
        .form-section h3 {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--primary-900);
            margin: 0 0 var(--spacing-4) 0;
        }
        
        .form-group {
            margin-bottom: var(--spacing-4);
        }
        
        .form-label {
            display: block;
            margin-bottom: var(--spacing-2);
            font-weight: 600;
            color: var(--primary-800);
            font-size: var(--font-size-sm);
        }
        
        .form-input {
            width: 100%;
            padding: var(--spacing-3) var(--spacing-4);
            border: 2px solid rgba(134, 197, 255, 0.3);
            border-radius: var(--radius-lg);
            font-size: var(--font-size-sm);
            transition: all var(--transition-fast);
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-600);
            box-shadow: 0 0 0 3px rgba(46, 90, 167, 0.1);
        }
        
        .btn {
            padding: var(--spacing-3) var(--spacing-5);
            border-radius: var(--radius-lg);
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-sm);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(46, 90, 167, 0.3);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            border: 1px solid #0284c7;
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .btn-secondary {
            background: rgba(134, 197, 255, 0.1);
            color: var(--primary-700);
            border: 1px solid rgba(134, 197, 255, 0.3);
        }
        
        .btn-secondary:hover {
            background: rgba(134, 197, 255, 0.2);
        }
        
        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
        }
        
        /* Location List */
        .location-list {
            max-height: 500px;
            overflow-y: auto;
        }
        
        .location-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-3) var(--spacing-4);
            margin-bottom: var(--spacing-2);
            background: white;
            border: 1px solid rgba(134, 197, 255, 0.2);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
        }
        
        .location-item:hover {
            border-color: rgba(46, 90, 167, 0.3);
            box-shadow: 0 2px 8px rgba(46, 90, 167, 0.1);
        }
        
        .location-name {
            font-weight: 500;
            color: var(--primary-900);
            font-size: var(--font-size-sm);
        }
        
        .location-actions {
            display: flex;
            gap: var(--spacing-2);
        }
        
        .btn-sm {
            padding: var(--spacing-1) var(--spacing-3);
            font-size: var(--font-size-xs);
        }
        
        .empty-state {
            text-align: center;
            padding: var(--spacing-8);
            color: var(--primary-600);
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
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
                            <a href="/admin/locations" class="admin-nav-link active">
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
                        <span>Kelola Lokasi</span>
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
                    <h1 class="admin-page-title">Kelola Lokasi</h1>
                    <p class="admin-page-subtitle">Tambah, edit, dan hapus lokasi fasilitas sekolah</p>
                </div>
                
                <!-- Success/Error Messages -->
                <?php if (isset($message)): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: '<?= addslashes(htmlspecialchars($message)) ?>',
                                icon: 'success',
                                confirmButtonColor: 'var(--primary-600)'
                            });
                        });
                    </script>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                text: '<?= addslashes(htmlspecialchars($error)) ?>',
                                icon: 'error',
                                confirmButtonColor: 'var(--primary-600)'
                            });
                        });
                    </script>
                <?php endif; ?>
                
                <div class="content-card">
                    <div class="form-grid">
                        <!-- Form Tambah Lokasi -->
                        <div class="form-section">
                            <h3><div class="icon icon-plus icon-sm" style="display: inline-block; margin-right: 8px; color: var(--primary-600);"></div>Tambah Lokasi Baru</h3>
                            <form method="POST" action="/admin/locations">
                                <input type="hidden" name="action" value="add">
                                
                                <div class="form-group">
                                    <label for="location_name" class="form-label">Nama Lokasi</label>
                                    <input 
                                        type="text" 
                                        id="location_name" 
                                        name="location_name" 
                                        class="form-input" 
                                        required
                                        maxlength="50"
                                        placeholder="Contoh: Ruang Kelas 12A"
                                    >
                                </div>
                                
                                <div class="form-group">
                                    <label for="location_description" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea 
                                        id="location_description" 
                                        name="location_description" 
                                        class="form-input" 
                                        rows="3"
                                        maxlength="500"
                                        placeholder="Deskripsi lokasi untuk memberikan penjelasan lebih detail..."
                                        style="resize: vertical; min-height: 80px;"
                                    ></textarea>
                                    <small style="color: #6b7280; font-size: 12px;">Maksimal 500 karakter</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <div class="icon icon-plus icon-sm"></div>
                                    Tambah Lokasi
                                </button>
                            </form>
                        </div>
                        
                        <!-- Daftar Lokasi -->
                        <div>
                            <h3><div class="icon icon-map-pin icon-sm" style="display: inline-block; margin-right: 8px; color: var(--primary-600);"></div>Daftar Lokasi (<?= count($locations) ?>)</h3>
                            <div class="location-list">
                                <?php if (!empty($locations)): ?>
                                    <?php foreach ($locations as $location): ?>
                                        <div class="location-item">
                                            <span class="location-name"><?= htmlspecialchars($location['nama_lokasi']) ?></span>
                                            <div class="location-actions">
                                                <button onclick="viewLocationDetail(<?= $location['id_lokasi'] ?>, '<?= addslashes(htmlspecialchars($location['nama_lokasi'])) ?>')" 
                                                        class="btn btn-info btn-sm">
                                                    <div class="icon icon-eye icon-sm"></div>
                                                    Detail
                                                </button>
                                                <button onclick="editLocation(<?= $location['id_lokasi'] ?>, '<?= addslashes(htmlspecialchars($location['nama_lokasi'])) ?>')" 
                                                        class="btn btn-secondary btn-sm">
                                                    <div class="icon icon-edit icon-sm"></div>
                                                    Edit
                                                </button>
                                                <button onclick="deleteLocation(<?= $location['id_lokasi'] ?>, '<?= addslashes(htmlspecialchars($location['nama_lokasi'])) ?>')" 
                                                        class="btn btn-danger btn-sm">
                                                    🗑️ Hapus
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-state">
                                        <p>Belum ada lokasi yang ditambahkan</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        function viewLocationDetail(id, name) {
            // Show loading
            Swal.fire({
                title: 'Memuat Detail...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Debug log
            console.log('Fetching location detail for ID:', id);
            
            // Fetch location details
            fetch(`/admin/locations/detail?id=${id}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        const location = data.data.location;
                        
                        Swal.fire({
                            title: `Detail Lokasi: ${location.nama_lokasi}`,
                            html: `
                                <div style="text-align: center; margin-bottom: 24px;">
                                    <div class="swal-icon-container swal-icon-primary">
                                        <div class="icon icon-map-pin icon-lg" style="color: white;"></div>
                                    </div>
                                </div>
                                <div style="text-align: left; padding: 20px;">
                                    <div style="margin-bottom: 20px;">
                                        <h4 style="margin: 0 0 8px 0; color: #374151; font-size: 16px; display: flex; align-items: center;">
                                            <div class="icon icon-map-pin icon-sm" style="margin-right: 8px; color: var(--primary-600);"></div>
                                            Nama Lokasi
                                        </h4>
                                        <p style="margin: 0; padding: 12px; background: #f9fafb; border-radius: 8px; color: #374151; font-size: 14px;">
                                            ${location.nama_lokasi}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h4 style="margin: 0 0 8px 0; color: #374151; font-size: 16px; display: flex; align-items: center;">
                                            <div class="icon icon-document-text icon-sm" style="margin-right: 8px; color: var(--primary-600);"></div>
                                            Deskripsi
                                        </h4>
                                        <p style="margin: 0; padding: 12px; background: #f9fafb; border-radius: 8px; color: #6b7280; font-size: 14px; line-height: 1.5;">
                                            ${location.deskripsi || 'Tidak ada deskripsi'}
                                        </p>
                                    </div>
                                </div>
                            `,
                            width: '500px',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: 'var(--primary-600)'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Gagal memuat detail lokasi',
                            icon: 'error',
                            confirmButtonColor: 'var(--primary-600)'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memuat detail: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: 'var(--primary-600)'
                    });
                });
        }
        
        function editLocation(id, name) {
            // First get the current location data including description
            fetch(`/admin/locations/detail?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const location = data.data.location;
                        
                        Swal.fire({
                            title: 'Edit Lokasi',
                            html: `
                                <div style="text-align: left;">
                                    <div style="margin-bottom: 16px;">
                                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Nama Lokasi</label>
                                        <input 
                                            id="edit-location-name" 
                                            type="text" 
                                            value="${location.nama_lokasi}" 
                                            maxlength="50"
                                            style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                                            placeholder="Nama lokasi"
                                        >
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Deskripsi</label>
                                        <textarea 
                                            id="edit-location-description" 
                                            rows="3" 
                                            maxlength="500"
                                            style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"
                                            placeholder="Deskripsi lokasi (opsional)"
                                        >${location.deskripsi || ''}</textarea>
                                        <small style="color: #6b7280; font-size: 12px;">Maksimal 500 karakter</small>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: 'var(--primary-600)',
                            width: '500px',
                            preConfirm: () => {
                                const name = document.getElementById('edit-location-name').value.trim();
                                const description = document.getElementById('edit-location-description').value.trim();
                                
                                if (!name) {
                                    Swal.showValidationMessage('Nama lokasi tidak boleh kosong');
                                    return false;
                                }
                                if (name.length > 50) {
                                    Swal.showValidationMessage('Nama lokasi maksimal 50 karakter');
                                    return false;
                                }
                                if (description.length > 500) {
                                    Swal.showValidationMessage('Deskripsi maksimal 500 karakter');
                                    return false;
                                }
                                
                                return { name, description };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '/admin/locations';
                                
                                const actionInput = document.createElement('input');
                                actionInput.type = 'hidden';
                                actionInput.name = 'action';
                                actionInput.value = 'edit';
                                
                                const idInput = document.createElement('input');
                                idInput.type = 'hidden';
                                idInput.name = 'location_id';
                                idInput.value = id;
                                
                                const nameInput = document.createElement('input');
                                nameInput.type = 'hidden';
                                nameInput.name = 'location_name';
                                nameInput.value = result.value.name;
                                
                                const descInput = document.createElement('input');
                                descInput.type = 'hidden';
                                descInput.name = 'location_description';
                                descInput.value = result.value.description;
                                
                                form.appendChild(actionInput);
                                form.appendChild(idInput);
                                form.appendChild(nameInput);
                                form.appendChild(descInput);
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    } else {
                        // Fallback to simple edit if detail fetch fails
                        Swal.fire({
                            title: 'Edit Lokasi',
                            input: 'text',
                            inputValue: name,
                            inputAttributes: {
                                maxlength: 50,
                                placeholder: 'Nama lokasi'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: 'var(--primary-600)',
                            inputValidator: (value) => {
                                if (!value || !value.trim()) {
                                    return 'Nama lokasi tidak boleh kosong'
                                }
                                if (value.trim().length > 50) {
                                    return 'Nama lokasi maksimal 50 karakter'
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '/admin/locations';
                                
                                const actionInput = document.createElement('input');
                                actionInput.type = 'hidden';
                                actionInput.name = 'action';
                                actionInput.value = 'edit';
                                
                                const idInput = document.createElement('input');
                                idInput.type = 'hidden';
                                idInput.name = 'location_id';
                                idInput.value = id;
                                
                                const nameInput = document.createElement('input');
                                nameInput.type = 'hidden';
                                nameInput.name = 'location_name';
                                nameInput.value = result.value.trim();
                                
                                form.appendChild(actionInput);
                                form.appendChild(idInput);
                                form.appendChild(nameInput);
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching location details:', error);
                    // Fallback to simple edit
                    Swal.fire({
                        title: 'Edit Lokasi',
                        input: 'text',
                        inputValue: name,
                        inputAttributes: {
                            maxlength: 50,
                            placeholder: 'Nama lokasi'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: 'var(--primary-600)',
                        inputValidator: (value) => {
                            if (!value || !value.trim()) {
                                return 'Nama lokasi tidak boleh kosong'
                            }
                            if (value.trim().length > 50) {
                                return 'Nama lokasi maksimal 50 karakter'
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '/admin/locations';
                            
                            const actionInput = document.createElement('input');
                            actionInput.type = 'hidden';
                            actionInput.name = 'action';
                            actionInput.value = 'edit';
                            
                            const idInput = document.createElement('input');
                            idInput.type = 'hidden';
                            idInput.name = 'location_id';
                            idInput.value = id;
                            
                            const nameInput = document.createElement('input');
                            nameInput.type = 'hidden';
                            nameInput.name = 'location_name';
                            nameInput.value = result.value.trim();
                            
                            form.appendChild(actionInput);
                            form.appendChild(idInput);
                            form.appendChild(nameInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
        }
        
        function deleteLocation(id, name) {
            Swal.fire({
                title: 'Hapus Lokasi?',
                text: `Apakah Anda yakin ingin menghapus lokasi "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/locations';
                    
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'delete';
                    
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'location_id';
                    idInput.value = id;
                    
                    form.appendChild(actionInput);
                    form.appendChild(idInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        
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
    </script>
</body>
</html>