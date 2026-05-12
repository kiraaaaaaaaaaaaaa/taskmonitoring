<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class capitaloutlay extends Model
{
    protected $table = 'capitaloutlay';
    protected $fillable = [
        'coName',
        'subprogramID',
        'coBudget',
        'updated_at',
        'created_at'
        
    ];
}
