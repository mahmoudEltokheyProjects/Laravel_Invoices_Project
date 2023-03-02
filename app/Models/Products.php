<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'product_name' ,
        'section_name' ,
        'description' ,
        'section_id'
    ];
    // "1:M" Relationship : Between "products" and "sections" table
    public function sectionsRelation()
    {
        return $this->belongsTo(Sections::class,'section_id');
    }
}
