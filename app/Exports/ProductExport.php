<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ProductExport implements FromCollection, WithHeadings{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::all();
    }
    public function headings(): array
    {
        return [
            'sku',
           'Description',
            'Normal Price',
           'Special Price',
           'created at',
           'updated at'
        ];
    }
}
