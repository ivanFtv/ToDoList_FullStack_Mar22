<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todolists', function (Blueprint $table) {
            $table->bigInteger('user_id')->after('id');
            $table->string('image')->after('description');
            $table->date('expiring_date')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todolists', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('image');
            $table->dropColumn('expiring_date');
        });
    }
};
