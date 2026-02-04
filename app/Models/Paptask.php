<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paptask extends Model
{
    use HasFactory;
    protected $table = 'paptask';
    protected $fillable = [
        'papID',
        'tasks',
    ];
}
