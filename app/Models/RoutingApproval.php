<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutingApproval extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }
    public function user()
    {
        # code...
        return $this->belongsTo(User::class);
    }


    public function user_level_2()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_2', 'id');
    }

    public function user_level_3()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_3', 'id');
    }

    public function user_level_4()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_4', 'id');
    }

    public function user_level_5()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_5', 'id');
    }

    public function user_level_6()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_6', 'id');
    }

    public function user_level_7()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_7', 'id');
    }

    public function user_level_8()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_8', 'id');
    }

    public function user_level_9()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id_app_9', 'id');
    }

}
