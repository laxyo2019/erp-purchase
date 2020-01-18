<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];
    protected $table = 'brands';

    public function category(){
    	return $this->belongsTo('App\item_category', 'category_id');
    }
}
