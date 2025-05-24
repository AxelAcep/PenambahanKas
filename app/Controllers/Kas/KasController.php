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

class KasController extends BaseController
{
    protected $uangModel;
    protected $transaksiModel;
    protected $kategoriModel;
    protected $db;


    public function __construct()
    {
        $this->uangModel = new UangKasModel();
        $this->transaksiModel = new TransaksiKasModel();
        
         $this->inboxModel = new InboxModel();
        $this->commentModel = new CommentModel();

        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();

        $this->kategoriModel = new KategoriModel();

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

        if ($saldoBaru < 0) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk perubahan ini');
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

        if ($saldoBaru < 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Saldo tidak cukup']);
        }

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
            'kas_pemasukan' => $this->transaksiModel->where('jenis', 'pemasukan')->findAll(),
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
            'kas_pengeluaran' => $this->transaksiModel->where('jenis', 'pengeluaran')->findAll(),
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
            if ($t['jenis'] == 'pemasukan') {
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

    public function getCSV() // Atau public function getCSV()
    {
        // 1. Ambil semua data transaksi (tetap ASC untuk urutan kronologis)
        $semuaTransaksi = $this->transaksiModel->orderBy('tanggal', 'ASC')->findAll();

        // 2. Ambil uang kas saat ini (nilai final dari database, sekali saja)
        $uangKasDB = $this->uangModel->first();
        $jumlahKasFinal = $uangKasDB ? intval($uangKasDB['jumlah']) : 0;

        // 3. Siapkan header CSV (baris pertama)
        $header = [
            'No',
            'Tanggal',
            'Hari',
            'Kategori',
            'Jumlah',
            'Jenis',
            'Keterangan',
        ];

        // 4. Siapkan data CSV
        $data_csv = [];
        $data_csv[] = $header; // Tambahkan header sebagai baris pertama

        $namaHari = [
            'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
            'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        ];

        $no = 1;
        foreach ($semuaTransaksi as $t) {
            $tanggalObj = strtotime($t['tanggal']);
            $hariSingkat = date('D', $tanggalObj);
            $hariLengkap = $namaHari[$hariSingkat]; // Ambil nama hari dalam Bahasa Indonesia

            $row = [
                $no++,
                date('d-m-Y', $tanggalObj),
                $hariLengkap,
                ucfirst($t['kategori']),
                intval($t['jumlah']), // Biarkan sebagai angka
                ucfirst($t['jenis']),
                $t['keterangan'] ?? '-',
            ];
            $data_csv[] = $row;
        }

        // Opsional: Tambahkan baris ringkasan di akhir CSV (seperti di PDF)
        // Ini akan sangat membantu user saat membuka di spreadsheet
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        foreach ($semuaTransaksi as $t) {
            if ($t['jenis'] == 'pemasukan') {
                $totalPemasukan += intval($t['jumlah']);
            } else {
                $totalPengeluaran += intval($t['jumlah']);
            }
        }

        $data_csv[] = ['', '', '', 'TOTAL PEMASUKAN', $totalPemasukan, '', '', ''];
        $data_csv[] = ['', '', '', 'TOTAL PENGELUARAN', $totalPengeluaran, '', '', ''];
        $data_csv[] = ['', '', '', 'SALDO AKHIR', $jumlahKasFinal, '', '', ''];


        // 5. Siapkan header HTTP untuk unduhan CSV
        $filename = 'Laporan_Kas_Lengkap_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // 6. Buat output CSV
        $output = fopen('php://output', 'w'); // Buka output stream

        foreach ($data_csv as $row) {
            fputcsv($output, $row); // Tulis setiap baris ke CSV
        }

        fclose($output); // Tutup output stream
        exit(); // Hentikan eksekusi script setelah mengirim file
    }



}
