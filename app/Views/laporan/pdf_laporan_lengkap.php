<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 10pt; }
        h1, h2, h3 { text-align: center; color: #333; }
        hr { border: 0.5px solid #eee; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .info { margin-bottom: 20px; text-align: center; }
        .info p { margin: 5px 0; }
        .total-kas { font-size: 14pt; font-weight: bold; text-align: center; margin-top: 30px; margin-bottom: 30px; color: #28a745; }
        .summary-box { border: 1px solid #ccc; padding: 15px; margin-bottom: 30px; background-color: #f9f9f9; border-radius: 5px; }
        .summary-box p { margin: 5px 0; }
        .total-pemasukan { color: #28a745; font-weight: bold; }
        .total-pengeluaran { color: #dc3545; font-weight: bold; }
        .footer { text-align: center; margin-top: 50px; font-size: 8pt; color: #777; }
    </style>
</head>
<body>
    <h1><?= $title; ?></h1>
    <hr>
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> <?= $tanggal_sekarang; ?></p>
        <p><strong>Hari:</strong> <?= $hari_ini; ?></p>
        <p><strong>Jam:</strong> <?= $jam_saat_ini; ?></p>
    </div>

    <div class="total-kas">
        <p>Jumlah Uang Kas Saat Ini: <strong>Rp <?= number_format($jumlah_kas, 0, ',', '.'); ?></strong></p>
    </div>

    <h2>Ringkasan Total</h2>
    <div class="summary-box">
        <p>Total Pemasukan Keseluruhan: <span class="total-pemasukan">Rp <?= number_format($total_pemasukan_keseluruhan, 0, ',', '.'); ?></span></p>
        <p>Total Pengeluaran Keseluruhan: <span class="total-pengeluaran">Rp <?= number_format($total_pengeluaran_keseluruhan, 0, ',', '.'); ?></span></p>
    </div>

    <h2>Pemasukan Berdasarkan Kategori</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kategori_pemasukan)): ?>
                <?php foreach ($kategori_pemasukan as $kategori => $jumlah): ?>
                    <tr>
                        <td><?= ucfirst($kategori); ?></td>
                        <td>Rp <?= number_format($jumlah, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data pemasukan berdasarkan kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Pengeluaran Berdasarkan Kategori</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kategori_pengeluaran)): ?>
                <?php foreach ($kategori_pengeluaran as $kategori => $jumlah): ?>
                    <tr>
                        <td><?= ucfirst($kategori); ?></td>
                        <td>Rp <?= number_format($jumlah, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data pengeluaran berdasarkan kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Detail Semua Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php if (!empty($semua_transaksi)): ?>
                <?php foreach ($semua_transaksi as $t): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($t['tanggal'])); ?></td>
                        <td><?= ucfirst($t['kategori']); ?></td>
                        <td>Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></td>
                        <td><?= ucfirst($t['jenis']); ?></td>
                        <td><?= $t['keterangan'] ?? '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis pada tanggal <?= date('d-m-Y'); ?>.</p>
    </div>
</body>
</html>