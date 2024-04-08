<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTrxAnggaran extends Model
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
    public function trx_anggaran_header()
    {
        return $this->belongsTo(TrxAnggaranHeader::class);
    }
    public function master_anggaran()
    {
        return $this->belongsTo(MasterAnggaran::class);
    }
}
