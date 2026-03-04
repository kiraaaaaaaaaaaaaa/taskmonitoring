<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class divisions extends Model
{
    protected $table = 'divisions';
    protected $fillable = [
        'division_short_name',
        'division_name',
        'sectorID',
    ];
}
