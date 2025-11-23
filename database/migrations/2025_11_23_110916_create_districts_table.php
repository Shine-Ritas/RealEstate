<?php

use App\Models\Province;
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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->char('d_code', 12)->unique();
            $table->string('d_name');
            $table->char('p_code', 10);
            $table->foreign('p_code')->references('p_code')->on('provinces')->onDelete('cascade');
            $table->timestamps();
            $table->index('d_code');
            $table->index('p_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
