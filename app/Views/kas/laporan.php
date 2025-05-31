<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?= $title; ?></title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Ircham Ali" />
    <link rel="shortcut icon" href="/assets/frontend/img/apple-touch-icon.png" />

    <!-- Styles -->
    <link href="/assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/uniform/css/uniform.default.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/line-icons/simple-line-icons.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/waves/waves.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/slidepushmenus/css/component.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/toastr/jquery.toast.min.css" rel="stylesheet" />
    <link href="/assets/backend/css/modern.min.css" rel="stylesheet" />
    <link href="/assets/backend/css/themes/dark.css" class="theme-color" rel="stylesheet" />
    <link href="/assets/backend/css/custom.css" rel="stylesheet" />
    <link href="/assets/backend/css/dropify.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        main.page-content {
            height: 90%;
            display: flex;
            flex-direction: column;
        }
        .page-inner {
            flex-grow: 1;
            overflow-y: auto;
        }
        .container-fluid, #main-wrapper {
            height: 90%;
        }
    </style>
</head>

<body class="page-header-fixed compact-menu page-sidebar-fixed">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <?= $this->include('layout/sidebar-dashboard'); ?>

    <!-- Main Content -->
    <main class="page-content content-wrap">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="container-fluid">

                    <!-- Card Panel -->
                    <div class="row justify-content-center align-items-center">
                        <!-- Main Content -->
                        <div class="col-md-9 col-lg-12 py-4 px-4 justify-content-center align-items-center panel-white">
                            <h2 class="text-center mb-4">Dashboard Pemasukan</h2>

                            <!-- Uang Kas Saat Ini -->
                            <div class="card text-center mb-4 border-success">
                                <div class="card-body">
                                    <h4>Uang Kas Saat Ini</h4>
                                    <h2 class="text-success fw-bold">Rp <?= number_format($jumlah_kas, 0, ',', '.'); ?></h2>
                                </div>
                            </div>

                            <!-- 5 Transaksi Terakhir -->
                            <div class="card mb-4 border-success">
                                <div class="card-header">5 Transaksi Terakhir</div>
                                <ul class="list-group list-group-flush">
                                   <?php foreach ($lima_transaksi as $tr): ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <?= ucfirst($tr['kategori']); ?> - Rp <?= number_format($tr['jumlah'], 0, ',', '.'); ?>
                                            <span class="badge bg-<?= $tr['jenis'] == 'pemasukan' ? 'success' : 'danger'; ?>">
                                                <?= ucfirst($tr['jenis']); ?>
                                            </span>
                                        </li>
                                        <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Chart Section -->
                            <div class="row mb-4 justify-content-center align-items-center" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                                <div class="col-md-6">
                                    <div class="card border-success">
                                        <div class="card-header">Perbandingan Pemasukan vs Pengeluaran</div>
                                        <div class="card-body">
                                            <canvas id="chart-perbandingan" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-success">
                                        <div class="card-header">Pengeluaran Berdasarkan Kategori</div>
                                        <div class="card-body">
                                            <canvas id="chart-kategori" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel Transaksi -->
                            <div class="card border-success mb-5">
                                <div class="card-header">Tabel Transaksi</div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-success">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Kategori</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <?php $no = 1 + (5 * ($pager->getCurrentPage('transaksi') - 1)); ?>
                                                <?php foreach ($semua_transaksi as $t): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= date('d-m-Y', strtotime($t['tanggal'])); ?></td>
                                                    <td><?= ucfirst($t['kategori']); ?></td>
                                                    <td>Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></td>
                                                    <td> <?= ucfirst($t['jenis']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                    </table>
                                    <!-- Pagination -->
                                    <nav>
                                        <?= $pager->links('transaksi', 'bootstrap'); ?>
                                    </nav>
                                
                                   <div class="d-flex flex-row justify-content-between align-items-center mt-3" style="display: flex; flex-direction: row; justify-content: start; align-items: center; gap: 4rem; padding-bottom: 2rem;">
                                        <form action="<?= base_url('kas/laporan/csv'); ?>" method="get">
                                            <button type="submit" class="btn btn-success text-white fw-bold" style="font-size: 1.3rem; padding: 0.75rem 1.5rem;">
                                                <i class="bi bi-file-earmark-spreadsheet"></i> Export to CSV
                                            </button>
                                        </form>
                                        <form action="<?= base_url('kas/laporan/pdf'); ?>" method="get">
                                            <button type="submit" class="btn btn-danger text-white fw-bold" style="font-size: 1.3rem; padding: 0.75rem 1.5rem;">
                                                <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- /.main-content -->
                    </div><!-- /.row -->

                    <!-- Footer -->


                </div><!-- /.container-fluid -->
            </div><!-- /#main-wrapper -->
        </div><!-- /.page-inner -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/backend/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="/assets/backend/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/backend/plugins/pace-master/pace.min.js"></script>
    <script src="/assets/backend/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="/assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/backend/plugins/switchery/switchery.min.js"></script>
    <script src="/assets/backend/plugins/uniform/jquery.uniform.min.js"></script>
    <script src="/assets/backend/plugins/classie/classie.js"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/backend/plugins/waves/waves.min.js"></script>
    <script src="/assets/backend/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/backend/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/backend/plugins/toastr/jquery.toast.min.js"></script>
    <script src="/assets/backend/plugins/datatables/js/jquery.datatables.min.js"></script>
    <script src="/assets/backend/js/modern.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const ctxPerbandingan = document.getElementById('chart-perbandingan').getContext('2d');
        new Chart(ctxPerbandingan, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [<?= $total_pengeluaran; ?>, <?= $total_pemasukan; ?>],
                    backgroundColor: ['#A8D5BA', '#F5A9A9']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxKategori = document.getElementById('chart-kategori').getContext('2d');
        new Chart(ctxKategori, {
            type: 'pie',
            data: {
                labels: <?= $kategori_labels ?>,
                datasets: [{
                    data: <?= $kategori_data ?>,
                    backgroundColor: ['#A9CFE7', '#FFF3B0', '#C8BFE7', '#FAD6BF']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





</body>

</html>
