<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aspirasi Siswa</title>
    <style>
        * {
            margin: 10px;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 2px solid #2563eb;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16px;
            color: #374151;
            margin-bottom: 10px;
        }
        
        .header .meta {
            font-size: 11px;
            color: #6b7280;
        }
        
        .summary-section {
            margin-bottom: 5px;
        }
        
        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
            padding-bottom: 2px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
        }
        
        .summary-cell.label {
            font-weight: bold;
            background-color: #f3f4f6;
            width: 30%;
        }
        
        .summary-cell.value {
            text-align: center;
            font-weight: bold;
            color: #1f2937;
        }
        
        .filters-info {
            background-color: #f8fafc;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }
        
        .filters-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }
        
        .filter-item {
            margin-bottom: 4px;
            font-size: 11px;
            color: #4b5563;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        
        .data-table th {
            background-color: #1f2937;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #374151;
        }
        
        .data-table td {
            padding: 8px;
            border: 1px solid #d1d5db;
            font-size: 10px;
            vertical-align: top;
        }
        
        .data-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .data-table tbody tr:nth-child(odd) {
            background-color: white;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @page {
            margin: 3cm;
        }
        
        .text-truncate {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN ASPIRASI SISWA</h1>
        <h2>Sistem Informasi Pengelolaan Aspirasi Fasilitas Sekolah</h2>
        <div class="meta">
            Digenerate pada: <?= date('d F Y, H:i:s') ?> WIB<br>
            Administrator: <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Administrator') ?>
        </div>
    </div>
    
    <!-- Filter Information - Hidden to reduce space -->
    <?php if (true && !empty($filters)): ?>
    <div class="filters-info">
        <div class="filters-title">Filter yang Diterapkan:</div>
        <?php if (isset($filters['filter_type'])): ?>
            <?php if ($filters['filter_type'] === 'daily' && !empty($filters['date_from'])): ?>
                <div class="filter-item">• Filter: Per Hari - <?= date('d F Y', strtotime($filters['date_from'])) ?></div>
            <?php elseif ($filters['filter_type'] === 'monthly' && !empty($filters['month'])): ?>
                <div class="filter-item">• Filter: Per Bulan - <?= date('F Y', strtotime($filters['month'] . '-01')) ?></div>
            <?php elseif ($filters['filter_type'] === 'range'): ?>
                <?php if (!empty($filters['date_from'])): ?>
                    <div class="filter-item">• Tanggal Dari: <?= date('d F Y', strtotime($filters['date_from'])) ?></div>
                <?php endif; ?>
                <?php if (!empty($filters['date_to'])): ?>
                    <div class="filter-item">• Tanggal Sampai: <?= date('d F Y', strtotime($filters['date_to'])) ?></div>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if (!empty($filters['date_from'])): ?>
                <div class="filter-item">• Tanggal Dari: <?= date('d F Y', strtotime($filters['date_from'])) ?></div>
            <?php endif; ?>
            <?php if (!empty($filters['date_to'])): ?>
                <div class="filter-item">• Tanggal Sampai: <?= date('d F Y', strtotime($filters['date_to'])) ?></div>
            <?php endif; ?>
            <?php if (!empty($filters['month'])): ?>
                <div class="filter-item">• Bulan: <?= date('F Y', strtotime($filters['month'] . '-01')) ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($filters['id_kategori'])): ?>
            <?php 
            $selectedCategory = null;
            $categoryModel = new Category();
            foreach ($categoryModel->getAll() as $cat) {
                if ($cat['id_kategori'] == $filters['id_kategori']) {
                    $selectedCategory = $cat['ket_kategori'];
                    break;
                }
            }
            ?>
            <?php if ($selectedCategory): ?>
                <div class="filter-item">• Kategori: <?= htmlspecialchars($selectedCategory) ?></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($filters['status'])): ?>
            <div class="filter-item">• Status: <?= htmlspecialchars($filters['status']) ?></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <!-- Summary Statistics - Hidden to reduce space -->
    <?php if (false): ?>
    <div class="summary-section">
        <div class="summary-title">Ringkasan Statistik</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell label">Total Aspirasi</div>
                <div class="summary-cell value"><?= $reportData['summary']['total'] ?? 0 ?></div>
                <div class="summary-cell label">Menunggu</div>
                <div class="summary-cell value"><?= $reportData['summary']['menunggu'] ?? 0 ?></div>
            </div>
            <div class="summary-row">
                <div class="summary-cell label">Dalam Proses</div>
                <div class="summary-cell value"><?= $reportData['summary']['proses'] ?? 0 ?></div>
                <div class="summary-cell label">Selesai</div>
                <div class="summary-cell value"><?= $reportData['summary']['selesai'] ?? 0 ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Laporan & Analisis Section -->
    <div class="summary-section">
        <div class="summary-title">Laporan & Analisis</div>
        
        <?php if (empty($reportData['details'])): ?>
            <div class="no-data">
                Tidak ada data yang sesuai dengan filter yang dipilih
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 15%;">Siswa</th>
                        <th style="width: 20%;">Kategori</th>
                        <th style="width: 15%;">Lokasi</th>
                        <th style="width: 25%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportData['details'] as $aspiration): ?>
                        <tr>
                            <td><?= htmlspecialchars($aspiration['id_pelaporan']) ?></td>
                            <td>
                                <?php 
                                if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                                    echo date('d/m/Y', strtotime($aspiration['created_at']));
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($aspiration['nis']) ?></strong><br>
                                <small><?= htmlspecialchars($aspiration['kelas'] ?? '-') ?></small>
                            </td>
                            <td><?= htmlspecialchars($aspiration['ket_kategori']) ?></td>
                            <td><?= htmlspecialchars($aspiration['lokasi']) ?></td>
                            <td><?= htmlspecialchars($aspiration['ket']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Pengelolaan Aspirasi Fasilitas Sekolah</p>
        <p>© <?= date('Y') ?> - Semua hak dilindungi undang-undang</p>
    </div>
</body>
</html>