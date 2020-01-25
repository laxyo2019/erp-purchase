<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationReceived extends Model
{
    protected $guarded = [];
    protected $table = 'quotation_receiveds';

    public function vendorsDetail(){
    	return $this->belongsTo('App\vendor', 'vender_id');
    }
}
