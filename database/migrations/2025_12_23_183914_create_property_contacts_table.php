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
        Schema::create('property_contacts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Property::class);
            $table->enum('type',['office','agent']);
            $table->string('text');
            $table->string('icon');
            $table->enum("contact_type",['line','phone','email','website','facebook','instagram','twitter','youtube','linkedin','other']);
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_contacts');
    }
};
