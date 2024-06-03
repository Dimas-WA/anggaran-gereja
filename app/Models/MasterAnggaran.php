<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAnggaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }
    public function tahun_anggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }
}
