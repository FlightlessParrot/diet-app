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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status',['created','pending','confirmed','reject'])->default('created');
            $table->foreignIdFor(Specialist::class);
            $table->foreignIdFor(User::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
