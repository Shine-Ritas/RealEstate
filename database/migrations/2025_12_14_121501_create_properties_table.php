<?php

use App\Models\District;
use App\Models\Province;
use App\Models\Subdistrict;
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
        Schema::create('properties', function (Blueprint $table) {
            $table->ulid();
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->enum('property_type',['condo','house','apartment','townhouse','villa','land','commercial']);
            $table->enum('listing_type',['rent','sale','both']);
            $table->decimal('current_price',15,2)->nullable();
            $table->decimal('rent_price',15,2)->nullable();
            $table->decimal('sale_price', 15,2)->nullable();
            $table->char('currency','3');
            $table->string('owner_name')->nullable();

            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();

            $table->string('address',255);

            $table->mediumInteger('view_count')->default(0);

            $table->foreignIdFor(Province::class);
            $table->foreignIdFor(District::class);
            $table->foreignIdFor(Subdistrict::class);
            $table->string('zipcode',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
