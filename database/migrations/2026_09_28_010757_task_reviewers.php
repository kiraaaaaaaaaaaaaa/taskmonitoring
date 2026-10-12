<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_reviewers', function (Blueprint $table) {

    $table->id();

    $table->foreignId('task_id')
        ->constrained('tasks')
        ->cascadeOnDelete();

    $table->foreignId('reviewer_id')
        ->constrained('users');

    $table->unsignedInteger('review_order');

    $table->string('status')
        ->default('Pending');

    $table->text('remarks')
        ->nullable();

    $table->dateTime('returned_date')
        ->nullable();

    $table->dateTime('reviewed_at')
        ->nullable();

    $table->timestamps();

    $table->unique([
        'task_id',
        'reviewer_id'
    ]);

    $table->unique([
        'task_id',
        'review_order'
    ]);

});
    }
};
