<?php

use App\Models\Province;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('city');
            $table->string('code');
            $table->foreignIdFor(Province::class);
            $table->string('line_1',250)->nullable();
            $table->string('line_2',250)->nullable();
            $table->integer('addressable_id');
            $table->string('addressable_type');
            $table->boolean('park')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
