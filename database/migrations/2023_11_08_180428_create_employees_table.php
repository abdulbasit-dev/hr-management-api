<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->nullable()->constrained('employees', 'id')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('age');
            $table->date('hire_date');
            $table->float('salary', 12, 3);
            $table->string('gender');
            $table->string('job_title');
            $table->boolean('is_founder')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
