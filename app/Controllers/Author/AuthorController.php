<?php

namespace App\Controllers\Author;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use App\Models\VisitorModel;
use App\Models\UangKasModel;
use App\Models\TransaksiKasModel;

class AuthorController extends BaseController
{
    public function __construct()
    {
        $this->commentModel = new CommentModel();

        $this->visitorModel = new VisitorModel();

        $this->uangModel = new UangKasModel();
        $this->transaksiModel = new TransaksiKasModel();
    }
    public function index()
    {
        $visitor = $this->visitorModel->visitor_statistics();
        foreach ($visitor as $result) {
            $bulan[] = $result->tgl;
            $value[] = (float) $result->jumlah;
        }

        $monthly_visitors = $this->visitorModel->count_visitor_this_month();
        if ($monthly_visitors->getNumRows() > 0) {
            $row = $monthly_visitors->getRowArray();
            $visitor_this_month = $row['tot_visitor'];
        }
        $chrome_visitors = $this->visitorModel->count_chrome_visitors();
        if ($chrome_visitors->getNumRows() > 0) {
            $row = $chrome_visitors->getRowArray();
            $visitor_chrome = $row['chrome_visitor'];
            $chrome_visitor = ($visitor_chrome / $visitor_this_month) * 100;
        } else {
            $chrome_visitor = 0;
        }
        $firefox_visitors = $this->visitorModel->count_firefox_visitors();
        if ($firefox_visitors->getNumRows() > 0) {
            $row = $firefox_visitors->getRowArray();
            $visitor_firefox = $row['firefox_visitor'];
            $firefox_visitor = ($visitor_firefox / $visitor_this_month) * 100;
        } else {
            $firefox_visitor = 0;
        }
        $explorer_visitors = $this->visitorModel->count_explorer_visitors();
        if ($explorer_visitors->getNumRows() > 0) {
            $row = $explorer_visitors->getRowArray();
            $visitor_explorer = $row['explorer_visitor'];
            $explorer_visitor = ($visitor_explorer / $visitor_this_month) * 100;
        } else {
            $explorer_visitor = 0;
        }
        $safari_visitors = $this->visitorModel->count_safari_visitors();
        if ($safari_visitors->getNumRows() > 0) {
            $row = $safari_visitors->getRowArray();
            $visitor_safari = $row['safari_visitor'];
            $safari_visitor = ($visitor_safari / $visitor_this_month) * 100;
        } else {
            $safari_visitor = 0;
        }
        $opera_visitors = $this->visitorModel->count_opera_visitors();
        if ($opera_visitors->getNumRows() > 0) {
            $row = $opera_visitors->getRowArray();
            $visitor_opera = $row['opera_visitor'];
            $opera_visitor = ($visitor_opera / $visitor_this_month) * 100;
        } else {
            $opera_visitor = 0;
        }
        $robot_visitors = $this->visitorModel->count_robot_visitors();
        if ($robot_visitors->getNumRows() > 0) {
            $row = $robot_visitors->getRowArray();
            $visitor_robot = $row['robot_visitor'];
            $robot_visitor = ($visitor_robot / $visitor_this_month) * 100;
        } else {
            $robot_visitor = 0;
        }
        $other_visitors = $this->visitorModel->count_other_visitors();
        if ($other_visitors->getNumRows() > 0) {
            $row = $other_visitors->getRowArray();
            $visitor_other = $row['other_visitor'];
            $other_visitor = ($visitor_other / $visitor_this_month) * 100;
        } else {
            $other_visitor = 0;
        }

        
        $uang_kas = $this->uangModel->first();
        $transaksi = $this->transaksiModel->findAll();

        // Pisahkan transaksi
        $transaksi_pemasukan = array_filter($transaksi, fn($t) => $t['jenis'] == 'pemasukan');
        $transaksi_pengeluaran = array_filter($transaksi, fn($t) => $t['jenis'] == 'pengeluaran');

        // Hitung chart per tanggal
        $tanggal_unik = array_unique(array_column($transaksi, 'tanggal'));
        sort($tanggal_unik);

         // Hitung total pemasukan dan pengeluaran
        $total_pemasukan = array_sum(array_map(fn($t) => $t['jenis'] == 'pemasukan' ? (int)$t['jumlah'] : 0, $transaksi));
        $total_pengeluaran = array_sum(array_map(fn($t) => $t['jenis'] == 'pengeluaran' ? (int)$t['jumlah'] : 0, $transaksi));

        // Siapkan data untuk chart (bisa label 2 item saja)
        $chart_labels = ['Pemasukan', 'Pengeluaran'];
        $chart_pemasukan = [$total_pemasukan];
        $chart_pengeluaran = [$total_pengeluaran];

        // Atau langsung buat dataset jadi satu array saja
        $chart_data = [$total_pemasukan, $total_pengeluaran];

        $data = [
            'akun' => $this->akun,
            'title' => 'Dashboard',
            'active' => $this->active,
            'total_comment' => $this->commentModel->getCommentsAuthor(session('id'))->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->getCommentsAuthor(session('id'))->where('comment_status', 0)->get()->getResultArray(),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),

            'month' => json_encode($bulan),
            'value' => json_encode($value),
            'all_visitors' => $this->visitorModel->count_all_visitors(),
            'all_post_views' => $this->visitorModel->count_all_post_views(),
            'all_posts' => $this->visitorModel->count_all_posts(),
            'all_comments' => $this->visitorModel->count_all_comments(),
            'top_five_articles' => $this->visitorModel->top_five_articles()->getResultArray(),
            'chrome_visitor' => $chrome_visitor,
            'firefox_visitor' => $firefox_visitor,
            'explorer_visitor' => $explorer_visitor,
            'safari_visitor' => $safari_visitor,
            'opera_visitor' => $opera_visitor,
            'robot_visitor' => $robot_visitor,
            'other_visitor' => $other_visitor,
            'uang_kas' => $uang_kas,
            'transaksi_pemasukan' => $transaksi_pemasukan,
            'transaksi_pengeluaran' => $transaksi_pengeluaran,
            'chart_labels' => $chart_labels,
            'chart_pemasukan' => $chart_pemasukan,
            'chart_pengeluaran' => $chart_pengeluaran,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
        ];

        return view('author/v_dashboard', $data);
    }
}
