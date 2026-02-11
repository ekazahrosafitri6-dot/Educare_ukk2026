<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Status & Progress Aspirasi - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            background: #ffffff !important;
        }
        
        .amalfi-header {
            background:var(--primary-900) !important;
        }
        
        .amalfi-header h1,
        .amalfi-header p {
            color: #ffffff !important;
        }
        
        .card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
        }
        
        .card-header {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .card-title {
            color: #0f172a !important;
        }
        
        .form-label {
            color: #0f172a !important;
            font-weight: 600;
        }
        
        .form-input {
            color: #0f172a !important;
            background: #ffffff !important;
            border: 2px solid #cbd5e1;
        }
        
        .form-input::placeholder {
            color: #64748b;
        }
        
        .text-sm {
            color: #475569 !important;
        }
        
        h2, h3 {
            color: #0f172a !important;
        }
        
        .amalfi-highlight {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            border-radius: 8px;
        }
        
        .amalfi-highlight p {
            color: #1e293b !important;
        }
        
        .alert-warning {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            color: #78350f;
        }
        
        .alert-info {
            background: #dbeafe;
            border: 2px solid #3b82f6;
            color: #1e3a8a;
        }
        
        .status-menunggu {
            background: #fbbf24;
            color: #78350f;
            font-weight: 600;
        }
        
        .status-proses {
            background: #60a5fa;
            color: #1e3a8a;
            font-weight: 600;
        }
        
        .status-selesai {
            background: #34d399;
            color: #065f46;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="amalfi-header">
        <div class="container">
            <h1 class="text-center m-0"><i class="bi bi-chat-dots-fill"></i> Status & Progress Aspirasi</h1>
            <p class="text-center m-0 mt-2" style="opacity: 0.9;">Lihat status, feedback dari admin, dan progress perbaikan untuk aspirasi Anda</p>
        </div>
    </div>

    <div class="container container-lg" style="margin-top: var(--spacing-8); margin-bottom: var(--spacing-8);">
        <!-- Search Form -->
        <div class="card mb-6">
            <div class="card-body">
                <form action="/student/feedback" method="GET" class="d-flex gap-4 items-end">
                    <div class="form-group mb-0" style="flex: 1;">
                        <label for="nis" class="form-label">Masukkan NIS Anda</label>
                        <input 
                            type="number" 
                            id="nis" 
                            name="nis" 
                            class="form-input" 
                            placeholder="Contoh: 1234567890"
                            value="<?= htmlspecialchars($nis ?? '') ?>"
                            max="9999999999"
                            min="1"
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search-heart-fill"></i> Cari Feedback
                    </button>
                </form>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <!-- Error Message -->
            <div class="alert alert-warning">
                <strong>⚠ Perhatian!</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif (isset($aspirations)): ?>
            <?php if (empty($aspirations)): ?>
                <!-- No Aspirations Found -->
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 4rem; margin-bottom: var(--spacing-4);"><i class="bi bi-envelope-arrow-down-fill"></i></div>
                        <h3 class="mb-3" style="color: #0f172a;">Belum Ada Aspirasi</h3>
                        <p class="text-sm" style="color: #475569;">
                            Anda belum memiliki aspirasi yang terdaftar dengan NIS <strong><?= htmlspecialchars($nis) ?></strong>
                        </p>
                        <a href="/student/aspiration" class="btn btn-primary mt-4">
                            Buat Aspirasi Baru
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Aspirations List -->
                <div class="mb-4">
                    <h2 class="text-xl" style="color: #0f172a;">Daftar Aspirasi untuk NIS: <?= htmlspecialchars($nis) ?></h2>
                    <p class="text-sm" style="color: #475569;">
                        Ditemukan <?= count($aspirations) ?> aspirasi
                    </p>
                </div>

                <?php foreach ($aspirations as $aspiration): ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-between items-center">
                            <div>
                                <h3 class="card-title m-0" style="color: #0f172a;">
                                    ID Pelaporan: <?= htmlspecialchars($aspiration['id_pelaporan']) ?>
                                </h3>
                                <p class="text-sm m-0 mt-1" style="color: #475569;">
                                    Kategori: <?= htmlspecialchars($aspiration['ket_kategori']) ?>
                                </p>
                            </div>
                            <div>
                                <?php
                                $statusClass = '';
                                $statusIcon = '';
                                switch ($aspiration['status']) {
                                    case 'Menunggu':
                                        $statusClass = 'status-menunggu';
                                        $statusIcon = '<i class="bi bi-hourglass-split"></i>';
                                        break;
                                    case 'Proses':
                                        $statusClass = 'status-proses';
                                        $statusIcon = '<i class="bi bi-arrow-repeat"></i>';
                                        break;
                                    case 'Selesai':
                                        $statusClass = 'status-selesai';
                                        $statusIcon = '<i class="bi bi-check-circle-fill"></i>';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <?= $statusIcon ?> <?= htmlspecialchars($aspiration['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-semibold" style="color: #0f172a;"><i class="bi bi-geo-alt-fill"></i> Lokasi</p>
                                    <p class="m-0" style="color: #1e293b;"><?= htmlspecialchars($aspiration['lokasi']) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold" style="color: #0f172a;"><i class="bi bi-calendar-check-fill"></i> Tanggal Dibuat</p>
                                    <p class="m-0" style="color: #1e293b;">
                                        <?php 
                                        if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                                            echo date('d/m/Y H:i', strtotime($aspiration['created_at']));
                                        } elseif (isset($aspiration['submitted_at']) && !empty($aspiration['submitted_at'])) {
                                            echo date('d/m/Y H:i', strtotime($aspiration['submitted_at']));
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div class="amalfi-highlight mb-4">
                                <p class="text-sm font-semibold mb-2" style="color: #0f172a;"><i class="bi bi-pencil-square"></i> Keterangan</p>
                                <p class="m-0" style="color: #1e293b;"><?= htmlspecialchars($aspiration['ket']) ?></p>
                            </div>

                            <?php if (!empty($aspiration['feedback'])): ?>
                                <div class="amalfi-highlight mb-4" style="border-left-color: #059669; background: #ecfdf5;">
                                    <p class="text-sm font-semibold mb-2" style="color: #065f46;"><i class="bi bi-chat-dots-fill"></i> Feedback dari Admin</p>
                                    <p class="m-0" style="color: #1e293b;"><?= nl2br(htmlspecialchars($aspiration['feedback'])) ?></p>
                                    <?php if (isset($aspiration['updated_at']) && !empty($aspiration['updated_at'])): ?>
                                        <p class="text-xs mt-2 m-0" style="color: #475569;">
                                            Diperbarui: <?= date('d/m/Y H:i', strtotime($aspiration['updated_at'])) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info mb-4">
                                    <strong><i class="bi bi-info-circle-fill"></i> Info:</strong> Belum ada feedback dari admin untuk aspirasi ini.
                                </div>
                            <?php endif; ?>

                            <!-- Progress Timeline -->
                            <?php if (!empty($aspiration['audit_trail'])): ?>
                                <div class="amalfi-highlight" style="border-left-color: #7c3aed; background: #faf5ff;">
                                    <p class="text-sm font-semibold mb-3" style="color: #6b21a8;"><i class="bi bi-clock-history"></i> Timeline Progress</p>
                                    <div style="position: relative;">
                                        <?php foreach ($aspiration['audit_trail'] as $index => $audit): ?>
                                            <div style="display: flex; gap: 12px; margin-bottom: <?= $index < count($aspiration['audit_trail']) - 1 ? '16px' : '0' ?>;">
                                                <div style="flex-shrink: 0; width: 24px; height: 24px; background: #7c3aed; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; position: relative;">
                                                    <?php
                                                    switch ($audit['action_type']) {
                                                        case 'created': echo '<i class="bi bi-file-earmark-plus-fill"></i>'; break;
                                                        case 'status_change': echo '<i class="bi bi-arrow-repeat"></i>'; break;
                                                        case 'feedback_added': echo '<i class="bi bi-chat-dots-fill"></i>'; break;
                                                        default: echo '<i class="bi bi-list-task"></i>'; break;
                                                    }
                                                    ?>
                                                    <?php if ($index < count($aspiration['audit_trail']) - 1): ?>
                                                        <div style="position: absolute; top: 24px; left: 50%; transform: translateX(-50%); width: 2px; height: 16px; background: #d1d5db;"></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div style="flex: 1; padding-bottom: 4px;">
                                                    <p style="margin: 0 0 4px 0; font-weight: 600; color: #6b21a8; font-size: 14px;">
                                                        <?php
                                                        switch ($audit['action_type']) {
                                                            case 'created': echo 'Aspirasi Dibuat'; break;
                                                            case 'status_change': echo 'Status Diubah'; break;
                                                            case 'feedback_added': echo 'Feedback Ditambahkan'; break;
                                                            default: echo 'Aktivitas'; break;
                                                        }
                                                        ?>
                                                    </p>
                                                    <p style="margin: 0 0 4px 0; color: #6b7280; font-size: 12px;">
                                                        <?= date('d/m/Y H:i', strtotime($audit['created_at'])) ?>
                                                        <?php if (!empty($audit['admin_username'])): ?>
                                                            oleh <?= htmlspecialchars($audit['admin_username']) ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <?php if (!empty($audit['new_value'])): ?>
                                                        <p style="margin: 0; color: #374151; font-size: 13px; background: white; padding: 8px; border-radius: 6px; border: 1px solid #e5e7eb;">
                                                            <?= htmlspecialchars($audit['new_value']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Navigation -->
        <div class="d-flex justify-between items-center mt-6">
            <a href="/" class="btn btn-outline">
                ← Kembali ke Beranda
            </a>
            <a href="/student/history?nis=<?= htmlspecialchars($nis ?? '') ?>" class="btn btn-secondary">
                <i class="bi bi-clock-history"></i> Lihat Histori Lengkap
            </a>
        </div>
    </div>
</body>
</html>
