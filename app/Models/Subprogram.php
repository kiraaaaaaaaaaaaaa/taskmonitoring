<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subprogram extends Model
{
    protected $table = 'subprogram';
    protected $fillable = [
        'subprogramname',
        'programID',
        'FY'
    ];
}
