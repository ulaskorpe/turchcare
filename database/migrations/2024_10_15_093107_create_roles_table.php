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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger(column: 'admins')->default(0);
            $table->tinyInteger('users')->default(0);
            $table->tinyInteger('posts')->default(0);
            $table->tinyInteger('payments')->default(0);
            $table->tinyInteger('blogs')->default(0);
            $table->tinyInteger('comments')->default(0);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
