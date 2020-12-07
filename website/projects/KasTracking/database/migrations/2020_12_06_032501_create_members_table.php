<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisasi_members', function (Blueprint $table) {
            $table->string('member_id', 150)->primary('member_id');
            $table->integer('user_id')->unsigned()->index('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('organisasi_id')->unsigned()->index('organisasi_id')->foreign('organisasi_id')->references('organisasi_id')->on('organisasi')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama', 150);
            $table->string('jenis_kelamin', 20);
            $table->string('tipe_pembayaran', 50);
            $table->string('keys', 10);
            $table->string('whatsapp',20)->unique()->nullable();
            $table->string('email',150)->unique()->nullable();
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
        Schema::dropIfExists('organisasi_members');
        Schema::dropForeign('lists_user_id_foreign');
        Schema::dropIndex('lists_user_id_index');
        Schema::dropColumn('user_id');
        Schema::dropForeign('lists_organisasi_id_foreign');
        Schema::dropIndex('lists_organisasi_id_index');
        Schema::dropColumn('organisasi_id');
    }
}
