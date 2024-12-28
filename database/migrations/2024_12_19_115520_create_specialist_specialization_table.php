<?php

use App\Models\Specialist;
use App\Models\Specialization;
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
        Schema::create('specialist_specialization', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Specialist::class);
            $table->foreignIdFor(Specialization::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialist_specialization');
    }
};
