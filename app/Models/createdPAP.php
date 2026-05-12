<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class createdPAP extends Model
{
    use HasFactory;
    protected $table = 'papmanagement';
   protected $fillable = [
        'papID',
        'description',
        'date',
        'location',
        'fromdate',
        'todate',
        'focal',
        'fundSource',
        'divisionID',
        'sectorID',
        'oosID'
    ];
}
