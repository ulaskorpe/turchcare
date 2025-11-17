<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;  
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->default(Str::uuid()); // UUID column
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique() ;
            $table->integer('admin_code')->unique();
            $table->integer('role_id')->default(1);
            $table->string('api_token')->nullable();
            $table->string(column: 'image')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /*
        protected $fillable = [
        'uuid',
        'role_id',
        'admin_code',
        'name',
        'email',
        'password',
        'phone',
        'api_token',
        'ip_address',
        'status'
    ];

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
