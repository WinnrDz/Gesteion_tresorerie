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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->integer("phone");
            $table->string("location");
            $table->string("availability");
            $table->integer("exp_years");
            $table->binary("cv");
            $table->string("linkedIn");
            $table->string("github");
            $table->string("portfolio_url");
            $table->enum("recruitment_pipeline",["new,interview,shortlisted,offer,rejected,hired"]);
            $table->integer("notation");
            $table->float("salaire");
            $table->date("application_date");
            $table->date("interview_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
