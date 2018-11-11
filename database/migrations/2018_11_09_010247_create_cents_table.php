<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cents', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('received_message_id');
            $table->json('response');

            $table->foreign('received_message_id')->references('id')->on('received_messages');
                // ->onDelete('restrict');

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
        Schema::dropIfExists('cents');
    }
}
