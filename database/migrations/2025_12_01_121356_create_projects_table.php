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
        Schema::create('projects', function (Blueprint $table) {
            $table->ulid();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('developer_id')->nullable()->constrained('developers');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('province_id')->constrained('provinces');
            $table->integer('total_floors')->nullable();
            $table->integer('total_units')->nullable();
            $table->year('year_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
