<?php

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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('type',['facebook','x','instagram','youtube','tiktok','linkedin', 'strona internetowa']);
            $table->string('url');
            $table->foreignIdFor(Specialist::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
