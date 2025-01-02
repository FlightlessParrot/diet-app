<?php

use App\Models\Specialist;
use App\Models\User;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Specialist::class);
            $table->text('text');
            $table->enum('grade',[1,2,3,4,5]);
            $table->enum('grade_atmosphere',[1,2,3,4,5]);
            $table->enum('grade_punctuality',[1,2,3,4,5]);
            $table->enum('grade_explanation',[1,2,3,4,5]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
