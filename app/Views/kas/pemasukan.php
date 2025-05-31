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

    <?= $this->include('layout/sidebar-dashboard'); ?>

    <main class="page-content content-wrap">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">

                                    <?php if (session()->getFlashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                                            <?= session()->getFlashdata('success'); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                            <?= session()->getFlashdata('error'); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <h2 class="mb-1" style="margin-bottom:25px;">Pemasukan Kas</h2>
                                    <form id="form-tambah-kas" class="form-inline" method="post" action="/kas/tambah/data">
                                        <?= csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px;">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" required />
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px; padding-left: 5px;">
                                                <label for="kategori">Anggota</label>
                                                <select class="form-control" id="kategori" name="kategori" required>
                                                    <option value="">Pilih Anggota</option>
                                                    <?php foreach ($kategori as $cat): ?>
                                                        <option value="<?= esc($cat['nama_kategori']); ?>">
                                                            <?= esc($cat['nama_kategori']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Tambah Kas</button>
                                    </form>
                                    <hr />

                                    <div class="table-responsive">
                                        <table id="kas-table" class="display table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Anggota</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                    <th>User</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-table">
                                                <?php $no = 1; ?> <?php if (!empty($kas_pemasukan)): ?>
                                                    <?php foreach ($kas_pemasukan as $kas): ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $kas['kategori']; ?></td>
                                                            <td><?= number_format($kas['jumlah']); ?></td>
                                                            <td><?= date('d-m-Y', strtotime($kas['tanggal'])); ?></td>
                                                            <td><?= $kas['user_name']; ?></td>

                                                            <td style="text-align: center;">
                                                                <a href="#" class="btn btn-xs btn-edit" data-toggle="modal" data-target="#editModal<?= $kas['kode_kas']; ?>">
                                                                    <span class="fa fa-pencil"></span>
                                                                </a>

                                                                <a href="#" class="btn btn-xs btn-delete" data-toggle="modal" data-target="#deleteModal<?= $kas['kode_kas']; ?>">
                                                                    <span class="fa fa-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada data pemasukan kas.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <div style="margin-top: 15px;">
                                            <button type="button" class="btn btn-danger" id="deleteAllButton" data-toggle="modal" data-target="#deleteAllModal" style="color: white;" <?= empty($kas_pemasukan) ? 'disabled' : ''; ?>>Delete All Pemasukan</button>
                                        </div>

                                        <?php if (!empty($kas_pemasukan)): ?>
                                            <?php foreach ($kas_pemasukan as $kas): ?>
                                                <div class="modal fade" id="editModal<?= $kas['kode_kas']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $kas['kode_kas']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form action="/kas/pemasukan/edit/<?= $kas['kode_kas']; ?>" method="post">
                                                            <?= csrf_field(); ?>
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel<?= $kas['kode_kas']; ?>">Edit Data Kas</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Anggota</label>
                                                                        <select name="kategori" class="form-control" required>
                                                                            <?php foreach ($kategori as $cat): ?>
                                                                                <option value="<?= esc($cat['nama_kategori']); ?>"
                                                                                    <?= ($cat['nama_kategori'] == $kas['kategori']) ? 'selected' : ''; ?>>
                                                                                    <?= esc($cat['nama_kategori']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jumlah</label>
                                                                        <input type="number" name="jumlah" class="form-control" value="<?= $kas['jumlah']; ?>" required />
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <?php foreach ($kas_pemasukan as $kas): ?>
                                                <div class="modal fade" id="deleteModal<?= $kas['kode_kas']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $kas['kode_kas']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel<?= $kas['kode_kas']; ?>">Konfirmasi Hapus Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST" action="/kas/pemasukan/delete/<?= $kas['kode_kas']; ?>">
                                                                <?= csrf_field(); ?>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus data kas dengan kode: <strong><?= $kas['kode_kas']; ?></strong>?</p>
                                                                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteAllModalLabel">Konfirmasi Hapus Semua Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="/kas/pemasukan/deleteAll">
                                                        <?= csrf_field(); ?>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus **semua data kas pemasukan**?</p>
                                                            <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus Semua!</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="/assets/backend/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="/assets/backend/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="/assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="/assets/backend/plugins/datatables/js/jquery.datatables.min.js"></script>
    <script src="/assets/backend/plugins/toastr/jquery.toast.min.js"></script>
    <script src="/assets/backend/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="/assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/backend/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/backend/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/backend/plugins/uniform/jquery.uniform.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/classie.js"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/main.js"></script>
    <script src="/assets/backend/plugins/waves/waves.min.js"></script>
    <script src="/assets/backend/js/modern.min.js"></script>
    <script src="/assets/backend/plugins/pace-master/pace.min.js"></script>
    <script src="/assets/backend/plugins/switchery/switchery.min.js"></script>
    <script src="/assets/backend/plugins/classie/classie.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable Anda
            const table = $('#kas-table').DataTable({
                "pageLength": 10,
                "lengthChange": true,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "pagingType": "simple",
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
                    "info": "Data Ke _START_ - _END_ Dari _TOTAL_ Data",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                } "error": function(xhr, error, thrown) {
            console.log('DataTables error:', error, thrown);
        }
            });

            // Bagian ini dihapus/dikomentari karena tidak lagi menggunakan AJAX untuk tambah kas:
            /*
            $('#form-tambah-kas').on('submit', function (e) {
                e.preventDefault();

                const jumlah = $('#jumlah').val();
                const kategori = $('#kategori').val();
                const csrfName = $('input[name^="csrf_"]').attr('name');
                const csrfToken = $('input[name^="csrf_"]').val();

                $.ajax({
                    url: '/kas/tambah/data',
                    type: 'POST',
                    data: {
                        jumlah: jumlah,
                        kategori: kategori,
                        [csrfName]: csrfToken
                    },
                    success: function (res) {
                        if (res.success) {
                            window.location.reload();
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: res.message || 'Gagal menambahkan data.',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right'
                            });
                        }
                    },
                    error: function (xhr) {
                        let errMsg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            errMsg = 'Respons server: ' + xhr.responseText.substring(0, 100) + '...';
                        }
                        $.toast({
                            heading: 'Error',
                            text: errMsg,
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                });
            });
            */
            // Tidak perlu ada JavaScript tambahan untuk mengisi data modal delete,
            // karena modal sudah dibuat unik untuk setiap item di loop PHP.
        });
    </script>
</body>

</html>