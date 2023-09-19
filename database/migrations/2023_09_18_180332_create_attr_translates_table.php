<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttrTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr_translates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attr_id')->nullable();
            $table->string('lang')->nullable();
            $table->string('title')->nullable();
            $table->string('attr')->nullable();
            $table->foreign('attr_id')->references('id')->on('prognoz_attrs')->onDelete('cascade');

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
        Schema::dropIfExists('attr_translates');
    }
}
