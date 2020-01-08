<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quotation extends Model
{
    protected $fillable = [
        'name', 'email', 'mobile', 'gst_number', 'alt_number', 'firm_name', 'register_number', 'item_final_amount'
    ];
}
