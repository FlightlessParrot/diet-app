<?php

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
        Schema::create('newsletter_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('disc');
            $table->string('path');
            $table->string('extension');
            $table->string('name');
            $table->enum('type',['specialists','clients']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_lists');
    }
};
