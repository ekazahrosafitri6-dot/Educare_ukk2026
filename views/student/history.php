<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Histori Aspirasi - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            background: #ffffff !important;
        }
        
        .amalfi-header {
            background: var(--primary-900) !important;
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
        
        .text-xs {
            color: #64748b !important;
        }
        
        h2, h3 {
            color: #0f172a !important;
        }
        
        .amalfi-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .amalfi-card h3 {
            color: #0f172a !important;
        }
        
        .amalfi-card p {
            color: #475569 !important;
        }
        

        .alert-warning {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            color: #78350f;
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
        
        .timeline-line {
            background: var(--primary-900) !important;
        }
        
        .timeline-dot {
            background: #ffffff;
            border: 4px solid #1e40af;
        }
    </style>
</head>
<body>
    <div class="amalfi-header">
        <div class="container">
            <h1 class="text-center m-0"><i class="bi bi-clock-history me-2"></i> Histori Aspirasi</h1>
            <p class="text-center m-0 mt-2" style="opacity: 0.9;">Lihat riwayat lengkap semua aspirasi Anda</p>
        </div>
    </div>

    <div class="container container-lg" style="margin-top: var(--spacing-8); margin-bottom: var(--spacing-8);">
        <!-- Search Form -->
        <div class="card mb-6">
            <div class="card-body">
                <form action="/student/history" method="GET" class="d-flex gap-4 items-end">
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
                        🔍 Lihat Histori
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
                        <div style="font-size: 4rem; margin-bottom: var(--spacing-4);"><i class="bi bi-inbox"></i></div>
                        <h3 class="mb-3" style="color: #0f172a;">Belum Ada Histori</h3>
                        <p class="text-sm" style="color: #475569;">
                            Anda belum memiliki histori aspirasi dengan NIS <strong><?= htmlspecialchars($nis) ?></strong>
                        </p>
                        <a href="/student/aspiration" class="btn btn-primary mt-4">
                            Buat Aspirasi Baru
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Statistics Summary -->
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <?php
                    $totalCount = count($aspirations);
                    $menungguCount = count(array_filter($aspirations, fn($a) => $a['status'] === 'Menunggu'));
                    $prosesCount = count(array_filter($aspirations, fn($a) => $a['status'] === 'Proses'));
                    $selesaiCount = count(array_filter($aspirations, fn($a) => $a['status'] === 'Selesai'));
                    ?>
                    
                    <div class="amalfi-card">
                        <div class="text-center">
                            <div style="font-size: 2rem; margin-bottom: var(--spacing-2);"><i class="bi bi-file-earmark-text"></i></div>
                            <h3 class="text-2xl font-bold m-0" style="color: #1e40af;"><?= $totalCount ?></h3>
                            <p class="text-sm m-0 mt-1" style="color: #475569;">Total Aspirasi</p>
                        </div>
                    </div>

                    <div class="amalfi-card">
                        <div class="text-center">
                            <div style="font-size: 2rem; margin-bottom: var(--spacing-2);"><i class="bi bi-arrow-repeat"></i></div>
                            <h3 class="text-2xl font-bold m-0" style="color: #2563eb;"><?= $prosesCount ?></h3>
                            <p class="text-sm m-0 mt-1" style="color: #475569;">Dalam Proses</p>
                        </div>
                    </div>

                    <div class="amalfi-card">
                        <div class="text-center">
                            <div style="font-size: 2rem; margin-bottom: var(--spacing-2);"><i class="bi bi-check-circle-fill"></i></div>
                            <h3 class="text-2xl font-bold m-0" style="color: #059669;"><?= $selesaiCount ?></h3>
                            <p class="text-sm m-0 mt-1" style="color: #475569;">Selesai</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline Header -->
                <div class="mb-4">
                    <h2 class="text-xl" style="color: #0f172a;">Timeline Aspirasi</h2>
                    <p class="text-sm" style="color: #475569;">
                        Menampilkan <?= count($aspirations) ?> aspirasi, diurutkan dari yang terbaru
                    </p>
                </div>

                <!-- Timeline -->
                <div style="position: relative; padding-left: var(--spacing-8);">
                    <!-- Timeline Line -->
                    <div class="timeline-line" style="position: absolute; left: 12px; top: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, #3b82f6, #1e40af);"></div>

                    <?php foreach ($aspirations as $index => $aspiration): ?>
                        <div style="position: relative; margin-bottom: var(--spacing-6);">
                            <!-- Timeline Dot -->
                            <div class="timeline-dot" style="position: absolute; left: -32px; top: 20px; width: 24px; height: 24px; border-radius: 50%; background: white; border: 4px solid #1e40af; z-index: 1;"></div>

                            <!-- Timeline Card -->
                            <div class="card">
                                <div class="card-header d-flex justify-between items-center">
                                    <div>
                                        <h3 class="card-title m-0" style="color: #0f172a;">
                                            <?= htmlspecialchars($aspiration['ket_kategori']) ?>
                                        </h3>
                                        <p class="text-xs m-0 mt-1" style="color: #64748b;">
                                            ID: <?= htmlspecialchars($aspiration['id_pelaporan']) ?> • 
                                            <?php 
                                            if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                                                echo date('d F Y, H:i', strtotime($aspiration['created_at']));
                                            } elseif (isset($aspiration['submitted_at']) && !empty($aspiration['submitted_at'])) {
                                                echo date('d F Y, H:i', strtotime($aspiration['submitted_at']));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div>
                                        <?php
                                        $statusClass = '';
                                        $statusIcon = '';
                                        switch ($aspiration['status']) {
                                            case 'Menunggu':
                                                $statusClass = 'status-menunggu';
                                                $statusIcon = '<i class="bi bi-clock"></i>';
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
                                    <div class="mb-3">
                                        <p class="text-sm font-semibold mb-1" style="color: #0f172a;"><i class="bi bi-geo-alt me-2"></i> Lokasi</p>
                                        <p class="m-0" style="color: #1e293b;"><?= htmlspecialchars($aspiration['lokasi']) ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-sm font-semibold mb-1" style="color: #0f172a;"><i class="bi bi-pencil-square me-2"></i> Keterangan</p>
                                        <p class="m-0" style="color: #1e293b;"><?= htmlspecialchars($aspiration['ket']) ?></p>
                                    </div>



                                    <div class="mt-3 pt-3" style="border-top: 1px solid #e2e8f0;">
                                        <p class="text-xs m-0" style="color: #64748b;">
                                            <?php if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])): ?>
                                                <strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($aspiration['created_at'])) ?>
                                                <?php if (isset($aspiration['updated_at']) && !empty($aspiration['updated_at']) && $aspiration['updated_at'] !== $aspiration['created_at']): ?>
                                                    • <strong>Diperbarui:</strong> <?= date('d/m/Y H:i', strtotime($aspiration['updated_at'])) ?>
                                                <?php endif; ?>
                                            <?php elseif (isset($aspiration['submitted_at']) && !empty($aspiration['submitted_at'])): ?>
                                                <strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($aspiration['submitted_at'])) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Navigation -->
        <div class="d-flex justify-between items-center mt-6">
            <a href="/" class="btn btn-outline">
                ← Kembali ke Beranda
            </a>
            <a href="/student/feedback?nis=<?= htmlspecialchars($nis ?? '') ?>" class="btn btn-secondary">
                💬 Lihat Feedback
            </a>
        </div>
    </div>
</body>
</html>
