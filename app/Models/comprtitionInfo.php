<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class comprtitionInfo extends Model
{
    use SoftDeletes;
    public $table = 'comprtitionInfo';
    protected $dates = ['deleted_at'];
}
