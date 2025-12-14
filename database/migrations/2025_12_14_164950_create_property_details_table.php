<?php

use App\Models\Property;
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
        Schema::create('property_details', function (Blueprint $table) {
            $table->ulid();
            $table->foreignIdFor(Property::class);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('floor')->comment('unit floor');
            $table->string('unit_number',50);
            $table->decimal('size_sqm', 8,2)->nullable();
            $table->decimal('land_size_sqm', 10,2)->nullable();
            $table->year('year_built')->nullable();

            $table->enum('furnished',['unfurnished','partial','fully']);
            $table->enum('ownership',['freehold','leasehold']);
            
            $table->enum('status',['active','pending','sold','rented','draft']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_details');
    }
};
