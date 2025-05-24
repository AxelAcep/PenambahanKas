<?php

use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('generate_pdf')) {
    function generate_pdf($html, $filename = 'document.pdf', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Penting untuk gambar dari URL (jika ada)
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();

        $dompdf->stream($filename, ['Attachment' => true]);
        exit(); // Penting untuk menghentikan eksekusi setelah streaming PDF
    }
}