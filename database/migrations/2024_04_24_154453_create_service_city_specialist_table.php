<?php

use App\Models\ServiceCity;
use App\Models\Specialist;
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
        Schema::create('service_city_specialist', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(ServiceCity::class);
            $table->foreignIdFor(Specialist::class);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_city_specialist');
    }
};
