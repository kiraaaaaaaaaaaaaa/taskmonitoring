<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usertype extends Model
{
    protected $table = 'usertype';
    protected $fillable = ['position', 'created_at', 'updated_at'];
}
