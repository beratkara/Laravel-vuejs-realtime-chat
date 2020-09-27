<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->string('name',200);
            $table->boolean('group')->default(false);
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->text('message')->nullable();
            $table->json('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('model_has_rooms', function (Blueprint $table) {
            $table->integer('room_id')->unsigned();
            $table->morphs('model');

            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');

            $table->primary(['room_id', 'model_id', 'model_type']);
        });

        Schema::create('model_has_messages', function (Blueprint $table) {
            $table->integer('message_id')->unsigned();
            $table->morphs('model');

            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');

            $table->primary(['message_id', 'model_id', 'model_type']);
        });

        Schema::create('room_has_messages', function (Blueprint $table) {
            $table->integer('message_id')->unsigned();
            $table->integer('room_id')->unsigned();

            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');

            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');

            $table->primary(['message_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('model_has_rooms');
        Schema::dropIfExists('model_has_messages');
        Schema::dropIfExists('room_has_messages');
    }
}
