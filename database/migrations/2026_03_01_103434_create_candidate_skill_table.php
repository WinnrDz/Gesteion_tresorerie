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
        Schema::create('candidate_skill', function (Blueprint $table) {

            $table->foreignId("skill_id")->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId("candidate_id")->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['skill_id', 'candidate_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_skill');
    }
};
