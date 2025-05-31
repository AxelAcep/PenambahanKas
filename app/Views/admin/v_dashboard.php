<!DOCTYPE html>
<html>

<head>
    <title><?= $title; ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Ircham Ali" />
    <link rel="shortcut icon" href="/assets/frontend/img/apple-touch-icon.png">

    <link href="/assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/uniform/css/uniform.default.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/waves/waves.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/metrojs/MetroJs.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

    <link href="/assets/backend/css/modern.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/css/themes/dark.css" class="theme-color" rel="stylesheet" type="text/css" />
    <link href="/assets/backend/css/custom.css" rel="stylesheet" type="text/css" />

    <script src="/assets/backend/plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

</head>

<body class="page-header-fixed compact-menu pace-done page-sidebar-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        <?= $this->include('layout/sidebar-dashboard'); ?>
        <div class="page-inner">
            <?= $this->include('layout/title-dashboard'); ?>

            <div id="main-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><?= number_format($all_visitors); ?></p>
                                    <span class="info-box-title">Unique Visitors</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><?= number_format($all_post_views); ?></p>
                                    <span class="info-box-title">Page Views</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-eye"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p><span class="counter"><?= number_format($all_posts); ?></span></p>
                                    <span class="info-box-title">All Posts</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-pencil"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><?= number_format($all_comments); ?></p>
                                    <span class="info-box-title">Comments Received</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-bubbles"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-white">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="visitors-chart">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Visitors This Month</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-18" style="height: 300px;">
                                                <canvas id="canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="stats-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Browser Stats</h4>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="list-unstyled">
                                                <li>Google Chrome<div class="text-success pull-right"><?= number_format($chrome_visitor); ?>%</div>
                                                </li>
                                                <li>Firefox<div class="text-success pull-right"><?= number_format($firefox_visitor); ?>%</div>
                                                </li>
                                                <li>Internet Explorer<div class="text-success pull-right"><?= number_format($explorer_visitor); ?>%</div>
                                                </li>
                                                <li>Safari<div class="text-success pull-right"><?= number_format($safari_visitor); ?>%</div>
                                                </li>
                                                <li>Opera<div class="text-success pull-right"><?= number_format($opera_visitor); ?>%</div>
                                                </li>
                                                <li>Robots<div class="text-success pull-right"><?= number_format($robot_visitor); ?>%</div>
                                                </li>
                                                <li>Others<div class="text-success pull-right"><?= number_format($other_visitor); ?>%</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Top 5 Articles</h4>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive project-stats">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Post Title</th>
                                                <th style="text-align: right;">Views</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($top_five_articles as $no => $row) :
                                                $no++;
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $no; ?></th>
                                                    <td><?= $row['post_title']; ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['post_views']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Uang Kas dan Transaksi Terbaru</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="info-box info-box-success">
                                            <div class="panel-body">
                                                <div class="info-box-stats">
                                                    <p><?= number_format($uang_kas['jumlah']); ?></p>
                                                    <span class="info-box-title">Uang Kas Saat Ini</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="info-box-icon">
                                            <i class="icon-arrow-up text-success"></i>
                                        </div>
                                        <h5><strong>Pemasukan Terakhir</strong></h5>
                                        <ul class="list-unstyled">
                                            <?php foreach (array_slice(array_reverse($transaksi_pemasukan), 0, 3) as $item): ?>
                                                <li><?= $item['tanggal']; ?> - <?= $item['kategori']; ?>: <span class="text-success">+<?= number_format($item['jumlah']); ?></span></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="info-box-icon">
                                            <i class="icon-arrow-down text-danger"></i>
                                        </div>
                                        <h5><strong>Pengeluaran Terakhir</strong></h5>
                                        <ul class="list-unstyled">
                                            <?php if (count($transaksi_pengeluaran) == 0): ?>
                                                <li><em>Tidak ada data</em></li>
                                            <?php else: ?>
                                                <?php foreach (array_slice(array_reverse($transaksi_pengeluaran), 0, 3) as $item): ?>
                                                    <li><?= $item['tanggal']; ?> - <?= $item['kategori']; ?>: <span class="text-danger">-<?= number_format($item['jumlah']); ?></span></li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:30px; display: flex;">
                                    <div class="col-md-6">
                                        <h5><strong>Perbandingan Pemasukan vs Pengeluaran</strong></h5>
                                        <div class="card-body">
                                            <canvas id="chart-perbandingan" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-footer">
                <p class="no-s"><?= date('Y'); ?> &copy; Powered by Ircham Ali.</p>
            </div>
        </div>
    </main>
    <div class="cd-overlay"></div>

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
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/main.js"></script>
    <script src="/assets/backend/plugins/flot/jquery.flot.min.js"></script>
    <script src="/assets/backend/plugins/flot/jquery.flot.time.min.js"></script>
    <script src="/assets/backend/plugins/flot/jquery.flot.symbol.min.js"></script>
    <script src="/assets/backend/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="/assets/backend/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/backend/js/modern.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // CounterUp Plugin
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });

            // Chart Perbandingan Pemasukan vs Pengeluaran
            const labelsPerbandingan = ['Pemasukan', 'Pengeluaran']; // Ganti chart_labels jika hanya 2 data ini
            const dataPerbandingan = [<?= $total_pemasukan; ?>, <?= $total_pengeluaran; ?>];

            const ctxPerbandingan = document.getElementById('chart-perbandingan').getContext('2d');
            new Chart(ctxPerbandingan, {
                type: 'bar',
                data: {
                    labels: labelsPerbandingan,
                    datasets: [{
                        label: 'Jumlah (Rp)',
                        data: dataPerbandingan,
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

            // Chart Visitors This Month
            var ctxVisitors = document.getElementById("canvas").getContext("2d");
            new Chart(ctxVisitors, {
                type: 'line', // Tipe chart sebagai 'line'
                data: {
                    labels: <?= $month; ?>, // Pastikan $month adalah array JSON valid dari PHP
                    datasets: [
                        {
                            label: 'Jumlah Pengunjung', // Label untuk dataset
                            backgroundColor: "rgba(34,186,160,0.2)", // Isi area di bawah garis
                            borderColor: "rgba(34,186,160,1)", // Warna garis
                            pointBackgroundColor: "rgba(34,186,160,1)", // Warna titik
                            pointBorderColor: "#fff", // Warna border titik
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(18,175,203,1)",
                            data: <?= $value; ?>, // Pastikan $value adalah array JSON valid dari PHP
                            fill: true // Area di bawah garis terisi
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Memungkinkan kontrol rasio aspek
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: { // Tambahkan skala X jika belum ada, untuk memastikan label bulan tampil
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            enabled: true
                        },
                        legend: { // Menampilkan legend
                            display: true
                        }
                    }
                }
            });

            // Kode untuk chartKas yang mungkin Anda miliki, pastikan elemen <canvas id="chartKas"></canvas> ada jika ingin menggunakannya
            // if (document.getElementById('chartKas')) {
            //     var ctxKas = document.getElementById('chartKas').getContext('2d');
            //     var chartKas = new Chart(ctxKas, {
            //         type: 'bar',
            //         data: {
            //             labels: <?= json_encode($chart_labels); ?>, // Perhatikan variabel ini, apakah sudah terdefinisi di PHP
            //             datasets: [{
            //                 label: 'Pemasukan',
            //                 data: <?= json_encode($chart_pemasukan); ?>, // Perhatikan variabel ini
            //                 backgroundColor: 'rgba(34,186,160,0.5)',
            //             }, {
            //                 label: 'Pengeluaran',
            //                 data: <?= json_encode($chart_pengeluaran); ?>, // Perhatikan variabel ini
            //                 backgroundColor: 'rgba(255,99,132,0.5)',
            //             }]
            //         },
            //         options: {
            //             scales: {
            //                 y: {
            //                     beginAtZero: true
            //                 }
            //             }
            //         }
            //     });
            // }

        });
    </script>
</body>

</html>