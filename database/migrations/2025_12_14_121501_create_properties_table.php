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
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->string('property_code',13)->unique();
            $table->longText('description');
            $table->enum('property_type',['condo','house','apartment','townhouse','villa','land','commercial','off-plan']);
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

            $table->char('p_code',6)->references('p_code')->on('provinces')->onDelete('cascade');
            $table->char('d_code',12)->references('d_code')->on('districts')->onDelete('cascade');
            $table->char('s_code',14)->references('s_code')->on('subdistricts')->onDelete('cascade');

            $table->foreign('p_code')->references('p_code')->on('provinces')->onDelete('cascade');
            $table->foreign('d_code')->references('d_code')->on('districts')->onDelete('cascade');
            $table->foreign('s_code')->references('s_code')->on('subdistricts')->onDelete('cascade');
            $table->string('zipcode',10);

            // index 
            $table->index('p_code');
            $table->index('d_code');
            $table->index('s_code');
            $table->index('zipcode');

            $table->index('latitude');
            $table->index('longitude');
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
