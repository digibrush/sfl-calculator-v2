<?php

namespace App\Exports;

use App\Models\Export;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('excel.products', [
            'products' => Product::where('type','standard')->get()
        ]);
    }
}
