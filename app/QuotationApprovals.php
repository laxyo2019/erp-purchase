<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationApprovals extends Model
{
    protected $guarded = [];
    protected $table = 'quotation_approvals';

    /*public function vendors_details(){
    		return $this->belongsTo('App\vendor', 'vendor_id', 'id');
    }*/
    public function vendors_mail_items(){
    		return $this->belongsTo('App\VendorsMailSend', 'quote_id', 'id');
    }
}
