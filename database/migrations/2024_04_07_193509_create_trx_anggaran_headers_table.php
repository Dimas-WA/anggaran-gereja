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
        Schema::create('trx_anggaran_headers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('seksi_id')->nullable();
            $table->string('tahun')->nullable();
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->string('original_file')->nullable();
            $table->enum('status', ['draft', 'send', 'waiting-approval', 'on-process', 'rejected', 'finish'])->default('draft');
            $table->double('total_pengajuan', 15,2)->default(0.00);
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
        Schema::dropIfExists('trx_anggaran_headers');
    }
};
