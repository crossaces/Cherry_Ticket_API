<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
   use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_ORDER";
    protected $table = "order";
    protected $fillable = ["JUMLAH", "SUBTOTAL", "ID_TRANSAKSI", "ID_TIKET"];

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

    public function tiket()
    {
        return $this->belongsTo(Tiket::class,'ID_TIKET');
    }
}
