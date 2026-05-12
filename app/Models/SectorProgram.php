<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectorProgram extends Model
{
    protected $table = 'sectorprogram';
    protected $fillable = [
        'programname',
        'budgetallotment',
        'FY'
    ];
}
