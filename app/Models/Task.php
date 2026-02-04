<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['PAP'
                            ,'task'
                            ,'preparer'
                            ,'assigned'
                            ,'activitydate'
                            ,'duedate'
                            ,'link'
                            ,'note'
                            ,'reviewer1'
                            ,'returneddate1'
                            ,'remarks1'
                            ,'status1'
                            ,'reviewer2'
                            ,'returneddate2'
                            ,'remarks2'
                            ,'status2'
                            ,'reviewer3'
                            ,'returneddate3'
                            ,'remarks3'
                            ,'status3'
                            ,'reviewer4'
                            ,'returneddate4'
                            ,'remarks4'
                            ,'status4'
                            ,'reviewer5'
                            ,'returneddate5'
                            ,'remarks5'
                            ,'status5'
                            ,'budget'
                            ,'costing'
                            ,'is_read'
                            ,'allocatedbudget' ];

    /** @use HasFactory<\Database\Factories\TaskFactory> */
    
}
