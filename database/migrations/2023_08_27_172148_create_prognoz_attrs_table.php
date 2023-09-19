<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrognozAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prognoz_attrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prognoz_id')->nullable();
            $table->string('title')->nullable();
            $table->string('kf')->nullable();
            $table->longText('attr')->nullable();
            $table->foreign('prognoz_id')->references('id')->on('prognozs')->onDelete('cascade');
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
        Schema::dropIfExists('prognoz_attrs');
    }
}
