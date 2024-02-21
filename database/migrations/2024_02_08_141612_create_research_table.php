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
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description")->nullable();
            $table->string("abstract")->nullable();

            $table->integer("plagiarism_percentage")->nullable();


            $table->enum("status",["draft", "under_review", "progress", "under_evaluate","publish","reject"])->default("draft");

//          AFTER SENDING THE RESEARCH
            $table->integer("marks")->nullable();
            $table->string("comments")->nullable();
            $table->dateTime("prepared_at")->nullable();
            $table->dateTime("administer_answered_at")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
