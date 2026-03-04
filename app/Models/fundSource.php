<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fundSource extends Model
{
    protected $table = 'fundsource';
    protected $fillable = [
        'fundName',
    ];
}
