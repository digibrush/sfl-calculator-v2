<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Quote;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generate($quote)
    {
        $quote = Quote::find($quote);
        $document = Document::create();
        $document->quote()->associate($quote);
        $document->save();
        return redirect()->back();
    }
}
