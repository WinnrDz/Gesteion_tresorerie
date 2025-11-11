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
        Schema::create('fixes', function (Blueprint $table) {
            $table->id();
            $table->float('salaire_net');
            $table->float('irg');
            $table->float('secu_35%');
            $table->float('abon_tel');
            $table->float('loyer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixes');
    }
};
