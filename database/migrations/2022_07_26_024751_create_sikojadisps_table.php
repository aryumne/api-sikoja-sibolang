<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSikojadispsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sikojadisps', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->foreignId('sikoja_id');
            $table->foreignId('instance_id');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('estimation_date')->nullable();
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
        Schema::dropIfExists('sikojadisps');
    }
}
