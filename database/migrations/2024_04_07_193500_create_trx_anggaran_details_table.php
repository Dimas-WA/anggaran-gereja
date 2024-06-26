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
        Schema::create('trx_anggaran_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('seksi_id')->nullable();
            $table->integer('trx_anggaran_header_id')->nullable();
            $table->integer('master_anggaran_id')->nullable();
            $table->double('jumlah', 15,2)->default(0.00);
            $table->string('keterangan')->nullable();
            $table->double('jumlah_realisasi', 15,2)->default(0.00);
            $table->string('keterangan_realisasi')->nullable();
            $table->enum('status_realisasi', ['none','draft','send','waiting-approval', 'on-process','rejected','finish'])->default('none');
            $table->string('doc_realisasi')->nullable();
            $table->string('original_file_realisasi')->nullable();
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
        Schema::dropIfExists('trx_anggaran_details');
    }
};
