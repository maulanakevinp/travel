<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

}
