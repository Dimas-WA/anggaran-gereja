<?php

namespace App\Traits;
use App\Models\Setting;
use App\Models\User;

trait Watzap {

  public function send_watzap($params)
  {
    /*

    Note :
    Untuk tujuan, bisa memilih antara :
    - $params['target']   (nomor telepon yang dituju) -> bisa ke beberapa nomor telepon sekaligus, dengan pemisah koma
    - $params['user_id']  (contacts dari user_id tertentu) -> bisa ke beberapa user_id sekaligus, dengan pemisah koma
    - $params['role']     (contacts dari user dengan role-role tertentu) -> bisa ke beberapa role sekaligus, dengan pemisah koma

    - $params['image']    (URL image) -> URL image yang memiliki keyword "localhost" dan "127.0.0.1" tidak dikirimkan
    - $params['message']  (Isi message) -> untuk penggunaan params user_id dan role bisa menggunakan nama dari database dengan menyertakan [NAME] pada text

    */

    $message  = $params['message'] ?? '';
    $role     = $params['role'] ?? '';
    $user_id  = $params['user_id'] ?? '';
    $target   = $params['target'] ?? '';
    $image    = $params['image'] ?? '';

    $continue = true;

    if(!$message || (!$target && !$user_id && !$role))
    {
      $continue = false;
    }

    if(!$continue)
    {
      \Log::channel('watzap')->info('Error: incorrect params', $params);
    }
    else
    {

        $settings = Setting::select('key','value')->get()->pluck('value','key')->toArray();

        //cek no wa aman atau tidak
        $dataSending = Array();
        $dataSending["api_key"] = $settings['watzap_api_key'];
        $dataSending["number_key"] = $settings['watzap_number_key'];
        $dataSending["phone_no"] = $settings['watzap_number'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $settings['watzap_server_validate'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($dataSending),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($response);
        // dd($json->status);
        if ($json->status == '200') {
            # code...
            $watzap_server            = $settings['watzap_server'] ?? '';
            $watzap_image_server      = $settings['watzap_image_server'] ?? '';
            $watzap_api_key           = $settings['watzap_api_key'] ?? '';
            $watzap_number_key        = $settings['watzap_number_key'] ?? '';
        }
        else {
            # code...
            $dataSending = Array();
            $dataSending["api_key"] = $settings['watzap_api_key'];
            $dataSending["number_key"] = $settings['watzap_number_key_backup'];
            $dataSending["phone_no"] = $settings['watzap_number_backup'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $settings['watzap_server_validate'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataSending),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($response);

            if ($json->status == '200') {
                # code...
                $watzap_server            = $settings['watzap_server'] ?? '';
                $watzap_image_server      = $settings['watzap_image_server'] ?? '';
                $watzap_api_key           = $settings['watzap_api_key'] ?? '';
                $watzap_number_key        = $settings['watzap_number_key_backup'] ?? '';
            }
            else {
                # code...

                \Log::channel('watzap')->info('Error: Validate WA Number '.$json->message);
                exit();
            }
        }

    //   $watzap_server            = $settings['watzap_server'] ?? '';
    //   $watzap_image_server      = $settings['watzap_image_server'] ?? '';
    //   $watzap_api_key           = $settings['watzap_api_key'] ?? '';
    //   $watzap_number_key        = $settings['watzap_number_key'] ?? '';
    //   $watzap_number_key_backup = $settings['watzap_number_key_backup'] ?? '';

      if(!$watzap_server || !$watzap_image_server || !$watzap_api_key || !$watzap_number_key)
      {
        \Log::channel('watzap')->info('Error: Incomplete Watzap credentials');
      }
      else
      {

        $phones = [];
        $names  = [];
        if($role)
        {
          $role = str_replace(' ', '', $role);
          $roles = explode(',',$role);
          $users = User::whereIn('type',$roles)->get();

          foreach($users as $user)
          {
            foreach($user->contacts as $contact)
            {
              $phones[] = $contact->phone;
              $names[]  = $contact->name;
            }
          }
        }
        else if($user_id)
        {

          $user_id = str_replace(' ', '', $user_id);
          $user_ids = explode(',',$user_id);
          $users = User::whereIn('id',$user_ids)->get();

          foreach($users as $user)
          {
            foreach($user->contacts as $contact)
            {
              $phones[] = $contact->phone;
              $names[]  = $contact->name;
            }
          }
        }
        else
        {
          $phones = explode(',',str_replace(' ','',$target));
        }

        if(!count($phones))
        {
          \Log::channel('watzap')->info('Error: No phone number to send', $params);
        }

        for($x=0; $x<count($phones);$x++)
        {
          $text_message = $message;
          $with_image = false;
          if($image)
          {
            if(str_contains($image, 'localhost') || str_contains($image, '127.0.0.1'))
            {
              $text_message = "[Cannot attach image from localhost] \n\n".$message;
            }
            else
            {
              $with_image = true;
            }
          }

          if(isset($names[$x]) && $names[$x])
          {
            $text_message = str_replace('[NAME]',$names[$x], $text_message);
          }

          $txt = '';
          if(!$with_image)
          {
            $dataSending = Array();
            $dataSending["api_key"] = $watzap_api_key;
            $dataSending["number_key"] = $watzap_number_key;
            $dataSending["phone_no"] = $phones[$x];
            $dataSending["message"] = $text_message;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $watzap_server,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($dataSending),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

          }
          else
          {
            $dataSending = Array();
            $dataSending["api_key"] = $watzap_api_key;
            $dataSending["number_key"] = $watzap_number_key;
            $dataSending["phone_no"] = $phones[$x];
            $dataSending["message"] = $text_message;
            $dataSending["url"] = $image;
            $dataSending["separate_caption"] = 0;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $watzap_image_server,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($dataSending),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            $txt = ' with Image';
          }

          $params['response'] = $response;

          if($response->status == '200' && $response->message = 'Successfully')
          {
            \Log::channel('watzap')->info('Sucess: Sending message '.$txt, $params);
          }
          else
          {
            \Log::channel('watzap')->info('Error: Sending message '.$txt, $params);
          }

        }

      }
    }
  }



}
