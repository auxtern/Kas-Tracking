<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganisasiLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisasi_logs', function (Blueprint $table) {
            $table->increments('log_id');
            $table->integer('user_id')->unsigned()->index('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('organisasi_id')->unsigned()->index('organisasi_id')->foreign('organisasi_id')->references('organisasi_id')->on('organisasi')->onDelete('cascade')->onUpdate('cascade');
            $table->string('pesan');
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
        Schema::dropIfExists('organisasi_logs');
        Schema::dropForeign('lists_user_id_foreign');
        Schema::dropIndex('lists_user_id_index');
        Schema::dropColumn('user_id');
        Schema::dropForeign('lists_organisasi_id_foreign');
        Schema::dropIndex('lists_organisasi_id_index');
        Schema::dropColumn('organisasi_id');
    }
}
