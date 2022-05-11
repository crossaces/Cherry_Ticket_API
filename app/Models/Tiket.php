<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_TIKET";
    protected $table = "tiket";
    protected $fillable = [
        "NAMA_TIKET",
        "FASILITAS",
        "HARGA",
        "TGL_MULAI_PENJUALAN",
        "TGL_SELESAI_PENJUALAN",
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
}
