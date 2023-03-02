<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoices::select('invoice_number', 'invoice_date', 'due_date','section_id', 'product',
                         'amount_collection','amount_commission', 'rate_vat', 'value_vat',
                         'total', 'status', 'payment_date','note'
                        )->get();
    }
}
