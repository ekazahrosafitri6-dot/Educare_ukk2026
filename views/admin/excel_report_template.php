<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aspirasi Siswa - Excel Export</title>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Aspirasi</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10pt;
        }
        
        /* Title Row */
        .title-row {
            background-color: #366092;
            color: white;
            font-weight: bold;
            font-size: 14pt;
            text-align: center;
            padding: 10px;
        }
        
        /* Info Row */
        .info-row {
            font-size: 9pt;
            font-style: italic;
            color: #666;
            padding: 5px;
        }
        
        /* Header Row */
        .header-row {
            background-color: #366092;
            color: white;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
        }
        
        .header-row th {
            padding: 8px;
            border: 1px solid #000;
            font-size: 11pt;
        }
        
        /* Data Rows */
        .data-row td {
            border: 1px solid #000;
            padding: 8px 5px;
            vertical-align: top;
            font-size: 10pt;
        }
        
        .data-row.even {
            background-color: #f5f5f5;
        }
        
        /* Column specific styles */
        .col-id {
            text-align: center;
            width: 80px;
        }
        
        .col-tanggal {
            text-align: center;
            width: 130px;
        }
        
        .col-siswa {
            width: 180px;
        }
        
        .col-kategori {
            width: 150px;
        }
        
        .col-lokasi {
            width: 120px;
        }
        
        .col-keterangan {
            width: 250px;
            word-wrap: break-word;
            white-space: normal;
        }
        
        .col-proses {
            text-align: center;
            width: 100px;
        }
        
        /* Footer Row */
        .footer-row {
            font-size: 9pt;
            font-style: italic;
            color: #666;
            padding: 10px 5px;
        }
    </style>
</head>
<body>
    <table id="excelTable">
        <!-- Title Row -->
        <tr>
            <td colspan="7" class="title-row">LAPORAN ASPIRASI SISWA</td>
        </tr>
        
        <!-- Info Row -->
        <tr>
            <td colspan="7" class="info-row">
                Tanggal Export: <?= date('d/m/Y H:i') ?> | 
                Administrator: <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Administrator') ?>
                <?php if (!empty($filters)): ?>
                    <br>Filter: 
                    <?php if (!empty($filters['date_from'])): ?>
                        Dari <?= date('d/m/Y', strtotime($filters['date_from'])) ?>
                    <?php endif; ?>
                    <?php if (!empty($filters['date_to'])): ?>
                        Sampai <?= date('d/m/Y', strtotime($filters['date_to'])) ?>
                    <?php endif; ?>
                    <?php if (!empty($filters['month'])): ?>
                        Bulan <?= date('F Y', strtotime($filters['month'] . '-01')) ?>
                    <?php endif; ?>
                    <?php if (!empty($filters['status'])): ?>
                        Status: <?= htmlspecialchars($filters['status']) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
        
        <!-- Empty Row for spacing -->
        <tr>
            <td colspan="7" style="height: 5px;"></td>
        </tr>
        
        <!-- Header Row -->
        <tr class="header-row">
            <th class="col-id">ID Pelaporan</th>
            <th class="col-tanggal">Tanggal</th>
            <th class="col-siswa">Siswa</th>
            <th class="col-kategori">Kategori</th>
            <th class="col-lokasi">Lokasi</th>
            <th class="col-keterangan">Keterangan</th>
            <th class="col-proses">Kelas</th>
        </tr>
        
        <!-- Data Rows -->
        <?php if (empty($reportData['details'])): ?>
            <tr class="data-row">
                <td colspan="7" style="text-align: center; padding: 20px; font-style: italic; color: #666;">
                    Tidak ada data yang sesuai dengan filter yang dipilih
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($reportData['details'] as $index => $aspiration): ?>
                <tr class="data-row <?= $index % 2 === 1 ? 'even' : '' ?>">
                    <td class="col-id"><?= htmlspecialchars($aspiration['id_pelaporan']) ?></td>
                    <td class="col-tanggal">
                        <?php 
                        if (isset($aspiration['created_at']) && !empty($aspiration['created_at'])) {
                            echo date('d/m/Y H:i', strtotime($aspiration['created_at']));
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td class="col-siswa">
                        <?= htmlspecialchars($aspiration['nis']) ?> 
                        <?= htmlspecialchars($aspiration['kelas'] ?? '') ?>
                    </td>
                    <td class="col-kategori"><?= htmlspecialchars($aspiration['ket_kategori']) ?></td>
                    <td class="col-lokasi"><?= htmlspecialchars($aspiration['lokasi']) ?></td>
                    <td class="col-keterangan"><?= htmlspecialchars($aspiration['ket']) ?></td>
                    <td class="col-proses"><?= htmlspecialchars($aspiration['kelas'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <!-- Empty Row for spacing -->
        <tr>
            <td colspan="7" style="height: 10px;"></td>
        </tr>
        
        <!-- Summary Row -->
        <tr>
            <td colspan="7" class="info-row">
                <strong>Ringkasan:</strong> 
                Total: <?= $reportData['summary']['total'] ?? 0 ?> | 
                Menunggu: <?= $reportData['summary']['menunggu'] ?? 0 ?> | 
                Proses: <?= $reportData['summary']['proses'] ?? 0 ?> | 
                Selesai: <?= $reportData['summary']['selesai'] ?? 0 ?>
            </td>
        </tr>
        
        <!-- Footer Row -->
        <tr>
            <td colspan="7" class="footer-row">
                Digenerate oleh Sistem Informasi Pengelolaan Aspirasi Fasilitas Sekolah
            </td>
        </tr>
    </table>
</body>
</html>