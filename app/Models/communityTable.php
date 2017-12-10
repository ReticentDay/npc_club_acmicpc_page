<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class communityTable extends Model
{
    use SoftDeletes;
    public $table = 'communitytabel';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
