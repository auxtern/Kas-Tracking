<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_notification', function (Blueprint $table) {
            $table->increments('notif_id');
            $table->integer('user_id')->unsigned()->index('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('pesan', 150);
            $table->date('dibaca')->nullable();
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
        Schema::dropIfExists('users_notification');
        Schema::dropForeign('lists_user_id_foreign');
        Schema::dropIndex('lists_user_id_index');
        Schema::dropColumn('user_id');
    }
}
