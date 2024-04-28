<?php

use App\Models\ServiceKind;
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
        Schema::create('service_kind_specialist', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Specialist::class);
            $table->foreignIdFor(ServiceKind::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_kind_specialist');
    }
};
