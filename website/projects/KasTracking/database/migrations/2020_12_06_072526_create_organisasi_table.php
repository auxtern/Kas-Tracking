<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisasi', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->increments('organisasi_id');
            $table->string('nama', 150);
            $table->string('lokasi', 200);
            $table->string('jenis_iuran', 50);
            $table->string('status_iuran',50);
            $table->integer('jumlah_iuran');
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
        Schema::dropIfExists('organisasi');
        Schema::dropForeign('lists_user_id_foreign');
        Schema::dropIndex('lists_user_id_index');
        Schema::dropColumn('user_id');
    }
}
