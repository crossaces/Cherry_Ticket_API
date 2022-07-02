<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_TRANSAKSI";
    protected $table = "transaksi";
    protected $fillable = [
        "TGL_TRANSAKSI",
        "STATUS_TRANSAKSI",
        "METODE_PEMBAYARAN",
        "BUKTI_PEMBAYARAN",
        "ID_PESERTA",
        "TOTAL_HARGA",
        "ID_EVENT",    
    ];

    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes["created_at"])) {
            return Carbon::parse($this->attributes["created_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (!is_null($this->attributes["updated_at"])) {
            return Carbon::parse($this->attributes["updated_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'ID_EVENT');
    }

     public function order()
    {
        return $this->hasMany(Order::class,"ID_TRANSAKSI");
    }
}
