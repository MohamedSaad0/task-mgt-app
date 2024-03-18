<?php

use App\Enums\TaskEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', [TaskEnum::PENDING, TaskEnum::COMPLETED, TaskEnum::CANCELED]);
            $table->foreignId('assignee_id')->nullable()->constrained('users');
            $table->foreignId('dependency_of')->nullable()->constrained('tasks');
            $table->dateTime('due_date_from')->nullable();
            $table->dateTime('due_date_to')->nullable();
            $table->timestamps();
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
