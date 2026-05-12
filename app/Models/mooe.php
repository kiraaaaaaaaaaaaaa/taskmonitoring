<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mooe extends Model
{
    protected $table = 'mooe';
    protected $fillable = [
        'mooeName',
        'subprogramID',
        'budgetallotment'
        ,'adjustedbudget',
        'type',
        'FY'
    ];
}
