<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function pdf_lain()
    {
        $pdf = PDF::loadview('pdf_lain');
        return $pdf->stream('pdf lain.pdf');
    }
}
