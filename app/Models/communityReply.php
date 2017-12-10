<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class communityReply extends Model
{
    use SoftDeletes;
    public $table = 'communityReply';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
