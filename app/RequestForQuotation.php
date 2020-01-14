<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestForQuotation extends Model
{
    protected $fillable = [
        'item_name', 'quantity', 'description', 'user_id', 'status'
    ];
}
