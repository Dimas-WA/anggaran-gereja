<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxAnggaranHeader extends Model
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
    public function trx_anggaran_details()
    {
        return $this->hasMany(TrxAnggaranDetail::class);
    }
}
