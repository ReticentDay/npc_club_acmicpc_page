<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class comprtitionList extends Model
{
    use SoftDeletes;
    public $table = 'comprtitionList';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
