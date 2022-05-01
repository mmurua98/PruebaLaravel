<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'total'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
