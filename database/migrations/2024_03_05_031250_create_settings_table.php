<?php

use App\Models\Setting;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });


        $default= [
            [
              'key'=>'watzap_server',
              'value'=>'https://api.watzap.id/v1/send_message',
              'description'=>'Default server for Watzap'
            ],
            [
              'key'=>'watzap_image_server',
              'value'=>'https://api.watzap.id/v1/send_image_url',
              'description'=>'Custom server for Watzap for sending message with image'
            ],
            [
              'key'=>'watzap_api_key',
              'value'=>'',
              'description'=>'Watzap main API key'
            ],
            [
              'key'=>'watzap_number_key',
              'value'=>'',
              'description'=>'Watzap number key'
            ],
            [
              'key'=>'watzap_number_key_backup',
              'value'=>'',
              'description'=>'Watzap backup number key'
            ],
            [
              'key'=>'daily_report_hour',
              'value'=>'07:00',
              'description'=>'For scheduled daily report broadcast'
            ]
          ];

          Setting::insert($default);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
