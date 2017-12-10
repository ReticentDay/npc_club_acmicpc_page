<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class communityGood extends Model
{
    use SoftDeletes;
    public $table = 'communitygood';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
