<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
}
