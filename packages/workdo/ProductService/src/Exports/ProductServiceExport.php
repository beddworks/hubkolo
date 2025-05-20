<?php

namespace Workdo\ProductService\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Workdo\ProductService\Entities\ProductService;
use Illuminate\Support\Facades\DB;

class ProductServiceExport implements FromCollection, WithHeadings
{
    public $productServices;

    public function __construct($productServices)
    {
        $this->productServices = $productServices;
    }

    public function collection()
    {
        return $this->productServices;
    }

    public function headings(): array
    {
        return [
            'Name',
            'SKU',
            'Sale_Price',
            'Purchase_Price',
            'Quantity',
            'Type',
            'Description',
        ];
    }
} 