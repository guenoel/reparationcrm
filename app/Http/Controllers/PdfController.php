<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $data = ['title' => 'Exemple de PDF', 'content' => 'Ceci est un test PDF avec DomPDF dans Laravel 11.'];
        
        $pdf = Pdf::loadView('pdf.example', $data);
        
        return $pdf->stream('document.pdf'); // Affiche le PDF dans le navigateur
        // return $pdf->download('document.pdf'); // Télécharge directement le PDF
    }
}
