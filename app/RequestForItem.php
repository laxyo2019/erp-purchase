<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestForItem extends Model
{
    protected $fillable = [
        'item_name', 'quantity', 'description', 'user_id', 'status'
    ];
}
