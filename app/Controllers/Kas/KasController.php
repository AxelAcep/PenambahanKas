<?php
namespace App\Controllers\Kas;

use Dompdf\Dompdf;
use Dompdf\Options;



use App\Controllers\BaseController;
use App\Models\UangKasModel;
use App\Models\TransaksiKasModel;
use App\Models\CategoryModel;
use App\Models\KategoriModel;
use App\Models\CommentModel;
use App\Models\InboxModel;
use App\Models\PostModel;
use App\Models\TagModel;
use App\Models\KasModel;
use App\Models\userModel;

class KasController extends BaseController
{
    protected $uangModel;
    protected $transaksiModel;
    protected $kategoriModel;
    protected $db;
    protected $kasModel;
    protected $userModel;

    public function __construct()
    {
        $this->kasModel = new KasModel();
        $this->uangModel = new UangKasModel();
        $this->transaksiModel = new TransaksiKasModel();
        
         $this->inboxModel = new InboxModel();
        $this->commentModel = new CommentModel();

        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();

        $this->kategoriModel = new KategoriModel();

        $this->userModel = new userModel();

        $this->db = \Config\Database::connect();
        helper(['text', 'pdf']);
    }

    public function editKas($kode_kas)
    {
        $newKategori = $this->request->getPost('kategori');
        $newJumlah = (int) $this->request->getPost('jumlah');

        if ($newJumlah <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0');
        }

        // Ambil data transaksi lama
        $transaksiLama = $this->transaksiModel->where('kode_kas', $kode_kas)->first();

        if (!$transaksiLama) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan');
        }

        $jumlahLama = (int) $transaksiLama['jumlah'];
        $jenisLama = $transaksiLama['jenis'];

        // Hitung ulang saldo
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);

        if ($jenisLama === 'pemasukan') {
            $saldoBaru = $saldoSekarang - $jumlahLama; // rollback pemasukan lama
        } else {
            $saldoBaru = $saldoSekarang + $jumlahLama; // rollback pengeluaran lama
        }

        // Cek jenis baru dari kategori (bisa kamu sesuaikan logika jika kategori tidak menentukan jenis)
        $jenisBaru = $transaksiLama['jenis']; // diasumsikan jenis tidak berubah (jika kamu ingin bisa diedit juga, tambahkan input 'jenis')

        // Terapkan perubahan baru
        if ($jenisBaru === 'pemasukan') {
            $saldoBaru += $newJumlah;
        } else {
            $saldoBaru -= $newJumlah;
        }

        // Update transaksi
        $this->transaksiModel->where('kode_kas', $kode_kas)->set([
            'kategori' => $newKategori,
            'jumlah' => $newJumlah
        ])->update();

        // Update saldo kas
        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function deleteKas($kode_kas)
    {
        // Ambil data terlebih dahulu
        $kas = $this->transaksiModel->find($kode_kas);

        if ($kas && $kas['jenis'] == 'pemasukan') {
            // Update uang kas
            $this->uangModel->update(1, [
                'jumlah' => $this->uangModel->first()['jumlah'] - $kas['jumlah']
            ]);

            // Hapus dari transaksi
            $this->transaksiModel->delete($kode_kas);
        }

        if ($kas && $kas['jenis'] == 'pengeluaran') {
            // Update uang kas
            $this->uangModel->update(1, [
                'jumlah' => $this->uangModel->first()['jumlah'] + $kas['jumlah']
            ]);

            // Hapus dari transaksi
            $this->transaksiModel->delete($kode_kas);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function index()
    {
        // Ambil bulan dan tahun dari query parameter, default ke bulan/tahun saat ini atau kosong
        $bulan = $this->request->getVar('bulan') ?? date('m'); // Default ke bulan saat ini
        $tahun = $this->request->getVar('tahun') ?? date('Y'); // Default ke tahun saat ini

        $kasPemasukan = $this->kasModel->getKasPemasukanFiltered($bulan, $tahun);

        $data = [
            'title' => 'Pemasukan Kas',
            'kas_pemasukan' => $kasPemasukan,
            'kategori' => $this->kategoriModel->findAll(), // Asumsi Anda punya model Kategori
            'current_bulan' => $bulan, // Kirim bulan dan tahun terpilih ke view
            'current_tahun' => $tahun,
        ];
        return view('kas/pemasukan_view', $data);
    }

    public function filterData()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        $kasData = $this->kasModel->getKasPemasukanFiltered($bulan, $tahun);

        return $this->response->setJSON([
            'success' => true,
            'data' => $kasData,
        ]);
    }

    public function deleteAllTransaksi($jenis) // Menerima parameter jenis
    {
        // Pastikan jenis yang diterima valid
        if (!in_array($jenis, ['pemasukan', 'pengeluaran'])) {
            return redirect()->back()->with('error', 'Jenis transaksi tidak valid.');
        }

        // Ambil semua transaksi berdasarkan jenis
        $transaksiToDelete = $this->transaksiModel->where('jenis', $jenis)->findAll();

        if (empty($transaksiToDelete)) {
            return redirect()->back()->with('error', 'Tidak ada data transaksi ' . $jenis . ' yang ditemukan.');
        }

        // Hitung total jumlah untuk penyesuaian uang kas
        $totalJumlah = 0;
        foreach ($transaksiToDelete as $transaksi) {
            $totalJumlah += $transaksi['jumlah'];
        }

        // Ambil jumlah uang kas saat ini
        $uangKasSaatIni = $this->uangModel->first()['jumlah'];

        if ($jenis == 'pemasukan') {
            // Kurangi uang kas dengan total pemasukan yang dihapus
            $this->uangModel->update(1, [
                'jumlah' => $uangKasSaatIni - $totalJumlah
            ]);
        } elseif ($jenis == 'pengeluaran') {
            // Tambahkan uang kas dengan total pengeluaran yang dihapus
            $this->uangModel->update(1, [
                'jumlah' => $uangKasSaatIni + $totalJumlah
            ]);
        }

        // Hapus semua transaksi berdasarkan jenis
        $this->transaksiModel->where('jenis', $jenis)->delete();

        return redirect()->back()->with('success', 'Semua data kas ' . $jenis . ' berhasil dihapus.');
    }


    public function getUangKas()
    {
        $model = new UangKasModel();
        return $this->response->setJSON($model->first());
    }

    public function getPemasukan()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->where('jenis', 'pemasukan')->findAll());
    }

    public function getPengeluaran()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->where('jenis', 'pengeluaran')->findAll());
    }

    public function getAllTransaksi()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->findAll());
    }

    public function tambahKas()
    {
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori');
        $userId = session('id'); // disamakan dengan kurangKas()

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Simpan transaksi sebagai pemasukan
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pemasukan',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori
        ]);

        // Update total uang kas
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang + $jumlah;

        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        // Ambil ulang data view pemasukan
        $data = [
            'akun' => $this->akun,
            'title' => 'Pemasukan Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->countAllResults(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->countAllResults(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pemasukan' => $this->transaksiModel->where('jenis', 'pemasukan')->findAll(),
        ];

        if ($this->request->isAJAX()) {
            $html = view('kas/pemasukan', $data);
            return $this->response->setJSON([
                'success' => true,
                'html' => $html
            ]);
        }
        session()->setFlashdata('success', 'Pemasukan kas berhasil ditambahkan.');
        return redirect()->to('/kas/pemasukan');
    }


    // Kurang kas (pengeluaran)
    public function kurangKas()
    {
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori') ?? 'pengeluaran_umum';
        $userId = session('id'); // disamakan dengan tambahKas()

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Ambil data saldo saat ini
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang - $jumlah;

        // Simpan transaksi sebagai pengeluaran
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pengeluaran',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori
        ]);

        // Update total uang kas
        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        // Ambil ulang data view pengeluaran
        $data = [
            'akun' => $this->akun,
            'title' => 'Pengeluaran Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->countAllResults(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->countAllResults(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pengeluaran' => $this->transaksiModel->where('jenis', 'pengeluaran')->findAll(),
        ];

        if ($this->request->isAJAX()) {
            $html = view('kas/pengeluaran', $data);
            return $this->response->setJSON([
                'success' => true,
                'html' => $html
            ]);
        }

        session()->setFlashdata('success', 'Pengeluaran kas berhasil dikurangkan.');
        return redirect()->to('/kas/pengeluaran');
    }


    public function viewPemasukan()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Post',
            'active' => 'kas', // ← ini yang ditambahkan
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pemasukan' => $this->transaksiModel->select('tbl_transaksi_kas.*, tbl_user.user_name')
            ->join('tbl_user', 'tbl_transaksi_kas.user_id = tbl_user.user_id')
            ->where('jenis', 'pemasukan')
            ->findAll(),
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('kas/pemasukan', $data);
    }


    public function viewPengeluaran()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Post',
            'active' => 'kas', // ← ini yang ditambahkan
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pengeluaran' => $this->transaksiModel->select('tbl_transaksi_kas.*, tbl_user.user_name')
            ->join('tbl_user', 'tbl_transaksi_kas.user_id = tbl_user.user_id')
            ->where('jenis', 'pengeluaran')
            ->findAll(),
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('kas/pengeluaran', $data);
    }


    public function viewLaporan()
    {
        // Ambil data jumlah uang kas
        $uangKas = $this->uangModel->first();
        $jumlahKas = $uangKas ? intval($uangKas['jumlah']) : 0;

        // Ambil semua transaksi
        $semuaTransaksi = $this->transaksiModel->orderBy('tanggal', 'DESC')->findAll();

        // Ambil 5 transaksi terakhir
        $limaTransaksi = array_slice($semuaTransaksi, 0, 5);

        // Siapkan data untuk chart perbandingan
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $kategoriPemasukan = [];

        foreach ($semuaTransaksi as $t) {
            $jumlah = intval($t['jumlah']);
            if ($t['jenis'] == 'pengeluaran') {
                $totalPemasukan += $jumlah;
                // Kategori chart pie
                if (!isset($kategoriPemasukan[$t['kategori']])) {
                    $kategoriPemasukan[$t['kategori']] = 0;
                }
                $kategoriPemasukan[$t['kategori']] += $jumlah;
            } else {
                $totalPengeluaran += $jumlah;
            }
        }

        // Ubah ke format JavaScript
        $kategoriLabels = json_encode(array_keys($kategoriPemasukan));
        $kategoriData = json_encode(array_values($kategoriPemasukan));

        $data = [
            'akun' => $this->akun,
            'title' => 'Laporan Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),

            // Data untuk halaman laporan
            'jumlah_kas' => $jumlahKas,
            'lima_transaksi' => $limaTransaksi,
            'semua_transaksi' => $this->transaksiModel->orderBy('tanggal', 'DESC')->paginate(5, 'transaksi'),
            'pager' => $this->transaksiModel->pager,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'kategori_labels' => $kategoriLabels,
            'kategori_data' => $kategoriData,
        ];

        return view('kas/laporan', $data);
    }

    // Menampilkan halaman dan semua kategori
    public function viewKategori()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'Laporan Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            
            'title' => 'Kategori Transaksi',
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('kas/kategori', $data);
    }

    // Simpan kategori baru
    public function simpanKategori()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
        return redirect()->to(base_url('kas/kategori'));
    }

    // Edit form
     public function editKategori()
    {
        // 1) Ambil POST
        $id             = $this->request->getPost('id');
        $nama_kategori  = $this->request->getPost('nama_kategori');

        // 2) Validasi
        if (empty($id) || empty($nama_kategori)) {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->to(site_url('kas/kategori'));
        }

        // 3) Simpan
        $model = new KategoriModel();
        if ($model->update($id, ['nama_kategori' => $nama_kategori])) {
            session()->setFlashdata('success', 'Kategori berhasil diubah.');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah kategori.');
        }

        // 4) Redirect kembali
        return redirect()->to(site_url('kas/kategori'));
    }


    // Proses update
    public function updateKategori($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
        return redirect()->to(base_url('kas/kategori'));
    }

    // Hapus kategori
    public function hapusKategori($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to(base_url('kas/kategori'));
    }

    public function getPDF()
    {
        // 1. Ekstrak data tanggal, waktu, hari, jam, saat ini
        date_default_timezone_set('Asia/Jakarta');
        $now = date('d-m-Y H:i:s');
        $hariIni = date('l'); // Full day name (e.g., Monday)
        $jamSaatIni = date('H:i');

        // Terjemahkan nama hari ke Bahasa Indonesia (opsional)
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        $hariIndonesia = $namaHari[$hariIni];

        // 2. Jumlah uang kas saat ini
        $uangKas = $this->uangModel->first();
        $jumlahKas = $uangKas ? intval($uangKas['jumlah']) : 0;

        // 3. Semua data rekap transaksi
        $semuaTransaksi = $this->transaksiModel->orderBy('tanggal', 'DESC')->findAll();

        // 4. Hitung total pemasukan dan pengeluaran per kategori
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $kategoriPemasukan = [];
        $kategoriPengeluaran = [];

        foreach ($semuaTransaksi as $t) {
            $jumlah = intval($t['jumlah']);
            if ($t['jenis'] == 'pemasukan') {
                $totalPemasukan += $jumlah;
                if (!isset($kategoriPemasukan[$t['kategori']])) {
                    $kategoriPemasukan[$t['kategori']] = 0;
                }
                $kategoriPemasukan[$t['kategori']] += $jumlah;
            } else {
                $totalPengeluaran += $jumlah;
                if (!isset($kategoriPengeluaran[$t['kategori']])) {
                    $kategoriPengeluaran[$t['kategori']] = 0;
                }
                $kategoriPengeluaran[$t['kategori']] += $jumlah;
            }
        }

        $data = [
            'tanggal_sekarang' => $now,
            'hari_ini' => $hariIndonesia,
            'jam_saat_ini' => $jamSaatIni,
            'jumlah_kas' => $jumlahKas,
            'semua_transaksi' => $semuaTransaksi,
            'total_pemasukan_keseluruhan' => $totalPemasukan, // Tambah ini
            'total_pengeluaran_keseluruhan' => $totalPengeluaran, // Tambah ini
            'kategori_pemasukan' => $kategoriPemasukan,
            'kategori_pengeluaran' => $kategoriPengeluaran,
            'title' => 'Laporan Kas Lengkap', // Judul untuk PDF
        ];

        // Load view yang akan di-render sebagai HTML untuk PDF
        $html = view('laporan/pdf_laporan_lengkap', $data); // Buat view ini

        // Panggil helper untuk generate dan download PDF
        generate_pdf($html, 'Laporan_Kas_Lengkap_' . date('Ymd_His') . '.pdf');
    }

    public function getCSV()
    {
        // 1. Ambil semua data transaksi (tetap ASC untuk urutan kronologis)
        $semuaTransaksi = $this->transaksiModel->orderBy('tanggal', 'ASC')->findAll();

        // Pisahkan data Pemasukan dan Pengeluaran
        $dataPemasukan = array_filter($semuaTransaksi, function ($t) {
            return $t['jenis'] == 'pemasukan';
        });
        $dataPengeluaran = array_filter($semuaTransaksi, function ($t) {
            return $t['jenis'] == 'pengeluaran';
        });

        // 2. Ambil uang kas saat ini (nilai final dari database, sekali saja)
        $uangKasDB = $this->uangModel->first();
        $jumlahKasFinal = $uangKasDB ? intval($uangKasDB['jumlah']) : 0;

        // 3. Siapkan header CSV
        // Kolom 'Kategori' diubah menjadi 'Anggota'
        $headerPemasukan = [
            'No',
            'Tanggal',
            'Hari',
            'Anggota', // Diubah dari 'Kategori'
            'Jumlah',
        ];

        // Header untuk pengeluaran tetap 'Kategori' jika memang itu yang diinginkan
        $headerPengeluaran = [
            'No',
            'Tanggal',
            'Hari',
            'Kategori', // Tetap 'Kategori' untuk pengeluaran
            'Jumlah',
        ];


        $namaHari = [
            'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
            'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        ];

        // 4. Siapkan data CSV
        $data_csv = [];

        // --- Bagian Pemasukan ---
        $data_csv[] = ['LAPORAN KAS PEMASUKAN']; // Judul tabel pemasukan
        $data_csv[] = $headerPemasukan; // Header untuk pemasukan menggunakan $headerPemasukan

        $no = 1;
        $totalPemasukan = 0;
        foreach ($dataPemasukan as $t) {
            $tanggalObj = strtotime($t['tanggal']);
            $hariSingkat = date('D', $tanggalObj);
            $hariLengkap = $namaHari[$hariSingkat];

            $row = [
                $no++,
                date('d-m-Y', $tanggalObj),
                $hariLengkap,
                ucfirst($t['kategori']), // Data dari DB tetap kategori, hanya judul kolomnya saja yang berubah
                intval($t['jumlah']),
            ];
            $data_csv[] = $row;
            $totalPemasukan += intval($t['jumlah']);
        }
        $data_csv[] = ['', '', '', 'TOTAL PEMASUKAN', $totalPemasukan];
        $data_csv[] = []; // Baris kosong sebagai pemisah

        // --- Bagian Pengeluaran ---
        $data_csv[] = ['LAPORAN KAS PENGELUARAN']; // Judul tabel pengeluaran
        $data_csv[] = $headerPengeluaran; // Header untuk pengeluaran menggunakan $headerPengeluaran

        $no = 1;
        $totalPengeluaran = 0;
        foreach ($dataPengeluaran as $t) {
            $tanggalObj = strtotime($t['tanggal']);
            $hariSingkat = date('D', $tanggalObj);
            $hariLengkap = $namaHari[$hariSingkat];

            $row = [
                $no++,
                date('d-m-Y', $tanggalObj),
                $hariLengkap,
                ucfirst($t['kategori']), // Data dari DB tetap kategori
                intval($t['jumlah']),
            ];
            $data_csv[] = $row;
            $totalPengeluaran += intval($t['jumlah']);
        }
        $data_csv[] = ['', '', '', 'TOTAL PENGELUARAN', $totalPengeluaran];
        $data_csv[] = []; // Baris kosong sebagai pemisah

        // --- Ringkasan Akhir ---
        $data_csv[] = ['RINGKASAN KAS'];
        $data_csv[] = ['Total Pemasukan', $totalPemasukan];
        $data_csv[] = ['Total Pengeluaran', $totalPengeluaran];
        $data_csv[] = ['SALDO AKHIR', $jumlahKasFinal];


        // 5. Siapkan header HTTP untuk unduhan CSV
        $filename = 'Laporan_Kas_Lengkap_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // 6. Buat output CSV
        $output = fopen('php://output', 'w'); // Buka output stream

        // Tulis UTF-8 BOM untuk kompatibilitas Excel
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        foreach ($data_csv as $row) {
            fputcsv($output, $row); // Tulis setiap baris ke CSV
        }

        fclose($output); // Tutup output stream
        exit(); // Hentikan eksekusi script setelah mengirim file
    }
    
    public function deleteAllKategori()
    {
        // Pastikan request adalah POST untuk keamanan
        if ($this->request->getMethod() === 'post') {
            try {
                // Menggunakan truncate() untuk menghapus semua data di tabel kategori
                $this->kategoriModel->truncate(); 
                
                // Atau, jika truncate() tidak tersedia atau ingin cara lain:
                // $this->kategoriModel->emptyTable(); // Metode lain untuk menghapus semua baris
                // Atau
                // $this->kategoriModel->where('id >', 0)->delete(); // Menghapus semua baris dengan kondisi

                return redirect()->back()->with('success', 'Semua kategori berhasil dihapus!');
            } catch (\Exception $e) {
                // Tangani kesalahan jika terjadi
                return redirect()->back()->with('error', 'Gagal menghapus semua kategori: ' . $e->getMessage());
            }
        } else {
            // Jika bukan POST request, arahkan kembali atau tampilkan error
            return redirect()->back()->with('error', 'Metode request tidak diizinkan.');
        }
    }



}
