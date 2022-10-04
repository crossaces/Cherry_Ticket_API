<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HasFactory;

    protected $primaryKey = "ID_WITHDRAW";
    protected $table = "withdraw";
    protected $fillable = [
        "TGL_WITHDRAW",
        "JUMLAH_WITHDRAW",
        "INCOME_ADMIN",
        "STATUS_WITHDRAW",
        "TOTAL_WITHDRAW",
        "METHOD_PAYMENT",
        "NOMOR_TRANSAKSI",
        "NAMA_TUJUAN",
        "ID_EO",        
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
