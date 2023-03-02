<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// "SoftDelete" Model
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes ;

    protected $fillable = [
        'invoice_number' , 'invoice_date' , 'due_date'  ,
        'product' , 'section_id' ,
        'amount_collection'  , 'amount_commission'  ,
        'discount' , 'rate_vat' , 'value_vat' ,
        'total' , 'status' , 'value_status' ,
        'note' , 'payment_date'
    ];
    protected $dates = ['deleted_at'];
    // "1:M" Relationship : Between "products" and "sections" table
    public function sectionsRelation()
    {
        return $this->belongsTo(Sections::class,'section_id');
    }
}
