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
        Schema::create('poin_histories', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 20);
            $table->string('outlet_id', 20);
            $table->string('admin_id', 20);
            $table->string('no_receipt', 100);
            $table->double('pembelian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poin_histories');
    }
};
