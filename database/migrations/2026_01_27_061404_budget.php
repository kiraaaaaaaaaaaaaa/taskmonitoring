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
        Schema::create('budget', function(Blueprint $table)
        {
            $table-> id();
            $table->timestamps();
            $table-> string('budgetPAP') -> nullable();
            $table-> decimal('allocatedbudget') -> nullable();
            $table-> decimal('costing') -> nullable();
            $table-> decimal('remaining')->storedAs("
                CASE
                    WHEN costing IS NULL OR costing = 0
                    THEN allocatedbudget
                    ELSE allocatedbudget - costing
                END
            ");;
            $table-> string('FY') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
