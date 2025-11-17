<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *         'receive_messages',        'friendship_allow',        'receive_emails',        'bid_inform',
     */
    public function up(): void
    {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->default(0) ;
            $table->tinyInteger('receive_messages')->after(column: 'user_id')->default(1) ;
            $table->tinyInteger('friendship_allow')->after(column: 'receive_messages')->default(1) ;
            $table->tinyInteger('receive_emails')->after(column: 'friendship_allow')->default(1) ;
            $table->tinyInteger('bid_inform')->after(column: 'receive_emails')->default(1) ;
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_settings', function (Blueprint $table) {
            //
        });
    }
};
