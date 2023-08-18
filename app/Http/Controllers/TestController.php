<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $quote = Quote::findOrFail(9);
        $data = [
            'quote' => $quote
        ];
        $pdf =  SnappyPDF::loadView('pdf.quote-financial', $data)
            ->setOption('lowquality', false)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('enable-javascript', false)
            ->setOption('javascript-delay', 13500)
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm')
            ->setOption('page-height', '295mm')
            ->setOption('page-width', '181mm')
            ->setPaper('a4', 'landscape');
        //        $pdf->save(storage_path('app/public/quote.pdf'));
        return $pdf->stream('invoice.pdf');
    }
}
