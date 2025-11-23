<?php

use App\Models\District;
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
        Schema::create('subdistricts', function (Blueprint $table) {
            $table->id();
            $table->char('s_code', 14)->unique();
            $table->string('s_name');
            // $table->foreignIdFor(District::class, 'd_code')->constrained()->onDelete('cascade');
            $table->char('d_code', 12);
            $table->foreign('d_code')->references('d_code')->on('districts')->onDelete('cascade');

            $table->string('zip_code');
            $table->timestamps();

            $table->index('s_code');
            $table->index('d_code');
            $table->index('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdistricts');
    }
};
