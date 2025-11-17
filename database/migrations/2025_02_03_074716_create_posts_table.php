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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('second_title')->nullable();
            $table->string('prologue')->nullable();
            $table->text('content')->nullable();
            $table->text('link')->nullable();
            $table->string('image')->nullable();
            $table->string('second_image')->nullable();
            $table->unsignedBigInteger('type_id')->default(0);
            $table->integer('count')->default(0);
            $table->enum('lang',['TR','EN','DE'])->default('TR');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
