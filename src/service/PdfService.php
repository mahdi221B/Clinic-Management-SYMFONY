<?php

namespace App\service;

use Dompdf\Dompdf;
use Dompdf\Options;
use phpDocumentor\Reflection\Types\This;

class PdfService
{
    private $dompdf;

    public function __construct(){
        $this->domPdf = new DomPdf();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf", [
            'Attachement' => true
        ]);
    }

    public function generateBinaryPDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        //returns pdf as string == binary that we can use later
        $this->domPdf->output();
    }
}