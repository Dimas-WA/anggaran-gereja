<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\Watzap;

class NotifWA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Watzap;

    protected $message;
    protected $role; //optional
    protected $user_id; //optional
    protected $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message,$role,$user_id,$image)
    {
        //
        $this->message = $message;
        $this->role = $role;
        $this->user_id = $user_id;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $params = [];
        if ($this->role != null) {
            # code...
            $params['role'] = $this->role;
        }
        if ($this->user_id != null) {

            $params['user_id'] = $this->user_id;
        }

        if ($this->image != null) {
            # code...
            $params['image']    = $this->image;
        }

        $params['message']  = $this->message;

        $this->send_watzap($params);
    }
}
