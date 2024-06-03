<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_trx_anggarans', function (Blueprint $table) {
            $table->id();
            $table->integer('trx_anggaran_header_id')->nullable();
            $table->integer('master_anggaran_id')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('seksi_id')->nullable();
            $table->string('tahun')->nullable();
            $table->enum('status', ['draft', 'approved', 'rejected', 'finished', 'add_detail', 'del_detail'])->default('draft');
            $table->integer('status_user_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('log_trx_anggarans');
    }
};
