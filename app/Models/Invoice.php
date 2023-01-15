<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'tbl_invoices';

    protected $fillable = [
        'id_product',
        'id_customer',
        'quantity',
        'total'
    ];

    //customer relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
