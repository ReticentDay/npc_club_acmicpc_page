<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsList extends Model
{
    use SoftDeletes;
    public $table = 'newstable';
    protected $dates = ['deleted_at'];
}
