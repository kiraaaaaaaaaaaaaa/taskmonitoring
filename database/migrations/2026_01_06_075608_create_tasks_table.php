<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('PAP')->nullable();
            $table->longText('task')->nullable();
            $table->integer('preparer')->nullable();
            $table->integer('assigned')->nullable();
            $table->date('activitydate')->nullable();
            $table->date('duedate')->nullable();
            $table->longText('link')->nullable();
            $table->longText('note')->nullable();
            $table->string('reviewer1')->nullable();
            $table->string('returneddate1')->nullable();
            $table->longText('remarks1')->nullable();
            $table->integer('status1')->nullable();
            $table->string('reviewer2')->nullable();
            $table->string('returneddate2')->nullable();
            $table->longText('remarks2')->nullable();
            $table->integer('status2')->nullable();
            $table->string('reviewer3')->nullable();
            $table->string('returneddate3')->nullable();
            $table->longText('remarks3')->nullable();
            $table->integer('status3')->nullable();
            $table->string('reviewer4')->nullable();
            $table->string('returneddate4')->nullable();
            $table->longText('remarks4')->nullable();
            $table->integer('status4')->nullable();
            $table->string('reviewer5')->nullable();
            $table->string('returneddate5')->nullable();
            $table->longText('remarks5')->nullable();
            $table->integer('status5')->nullable();
            $table->decimal('budget',18,2)->nullable();
            $table->decimal('costing',18,2)->nullable();
            $table->boolean('is_read')->nullable();
            $table->integer('allocatedbudget')->nullable();
             $table->decimal('remaining', 18, 2)->storedAs("
                CASE
                    WHEN costing IS NULL OR costing = 0
                    THEN budget
                    ELSE budget - costing
                END
            ");
             $table->decimal('progress_score', 5, 2)->storedAs("
        CAST(
            (
                (
                    (CASE WHEN status1 = 'Completed' THEN 1 ELSE 0 END) +
                    (CASE WHEN status2 = 'Completed' THEN 1 ELSE 0 END) +
                    (CASE WHEN status3 = 'Completed' THEN 1 ELSE 0 END) +
                    (CASE WHEN status4 = 'Completed' THEN 1 ELSE 0 END) +
                    (CASE WHEN status5 = 'Completed' THEN 1 ELSE 0 END)
                )
                +
                0.5 * (
                    (CASE WHEN status1 = 'In Progress' THEN 1 ELSE 0 END) +
                    (CASE WHEN status2 = 'In Progress' THEN 1 ELSE 0 END) +
                    (CASE WHEN status3 = 'In Progress' THEN 1 ELSE 0 END) +
                    (CASE WHEN status4 = 'In Progress' THEN 1 ELSE 0 END) +
                    (CASE WHEN status5 = 'In Progress' THEN 1 ELSE 0 END)
                )
            )
            /
            NULLIF(
                (
                    (CASE WHEN status1 IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN status2 IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN status3 IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN status4 IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN status5 IS NOT NULL THEN 1 ELSE 0 END)
                )
                -
                (
                    (CASE WHEN status1 = 'Not Applicable' THEN 1 ELSE 0 END) +
                    (CASE WHEN status2 = 'Not Applicable' THEN 1 ELSE 0 END) +
                    (CASE WHEN status3 = 'Not Applicable' THEN 1 ELSE 0 END) +
                    (CASE WHEN status4 = 'Not Applicable' THEN 1 ELSE 0 END) +
                    (CASE WHEN status5 = 'Not Applicable' THEN 1 ELSE 0 END)
                ),
            0)
        AS DECIMAL(5,2))
    ");
});

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
