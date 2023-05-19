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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('outlet_id', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('occupation', 20)->nullable();
            $table->string('province', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('address', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
