<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $fillable = [
        'invoice_id',
        'order_id',
        'product_id',
        'precio',
        'impuesto',
        'producto_total'
    ];

    public function invoice(){
        return $this->belongsTo('App\Invoice');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
