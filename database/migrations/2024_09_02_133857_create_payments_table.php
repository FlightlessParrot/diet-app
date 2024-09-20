<?php

use App\Models\Discount;
use App\Models\Offer;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('price');
            $table->string('currency')->default('PLN');
            $table->enum('status',['pending','accepted','rejected'])->default('pending');
            $table->foreignIdFor(Specialist::class);
            $table->foreignIdFor(Offer::class);
            $table->foreignIdFor(Discount::class)->nullable();
            $table->string('ing_transaction_id')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
