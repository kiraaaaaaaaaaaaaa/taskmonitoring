<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class taskReviewer extends Model
{
    use    HasFactory;

    protected $table = 'task_reviewers';
   protected $fillable = [
        'task_id',
        'reviewer_id',
        'review_order',
        'status',
        'remarks',
        'returned_date',
        'reviewed_at',
        'created_at',
        'updated_at'
       
    ];
}
