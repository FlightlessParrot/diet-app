<?php

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
        Schema::create('specialists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('title',['lic.', 'inż.', 'mgr', 'mgr inż.', 'dr', 'dr hab.', 'prof. dr hab.'])->nullable();
            $table->enum('specialization',['Dietetyk kliniczny', 'Dietetyk sportowy', 'Psychodietetyk'])->nullable();
            $table->string('name');
            $table->string('surname');
            $table->boolean('active')->default(false);
            $table->foreignIdFor(User::class);
            $table->integer('found_counter')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialists');
    }
};
