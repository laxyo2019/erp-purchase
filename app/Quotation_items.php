<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation_items extends Model
{
    protected $fillable = [
        'item_name', 'item_quantity', 'item_price', 'item_actual_amount', 'item_tax1_rate', 'item_tax1_amount', 'item_total_amount', 'quotation_id', 'vendor_regno'
    ];
}
