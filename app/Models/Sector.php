<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sector';
    protected $fillable = [
        'sector_short_name',
        'sector_long_name',
    ];
}
