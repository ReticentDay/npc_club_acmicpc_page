<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tests extends Model
{
    //
    protected $table = 'talktable';
    public $timestamps = false;
    protected $fillable = ['name','message'];

}
