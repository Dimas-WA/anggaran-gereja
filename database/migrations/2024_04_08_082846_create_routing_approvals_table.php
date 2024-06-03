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
        Schema::create('routing_approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_id_app_2')->nullable();
            $table->integer('user_id_app_3')->nullable();
            $table->integer('user_id_app_4')->nullable();
            $table->integer('user_id_app_5')->nullable();
            $table->integer('user_id_app_6')->nullable();
            $table->integer('user_id_app_7')->nullable();
            $table->integer('user_id_app_8')->nullable();
            $table->integer('user_id_app_9')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('routing_approvals');
    }
};
