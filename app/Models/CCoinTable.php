<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CCoinTable extends Model
{
    use SoftDeletes;
    public $table = 'ccointable';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
