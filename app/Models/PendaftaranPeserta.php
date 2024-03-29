<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftaranPeserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_PENDAFTARAN";
    protected $table = "pendaftaran_peserta";
    protected $fillable = [
        "DATA_PERTANYAAN",
        "STATUS_PENDAFTARAN",
        "ID_FORM_PENDAFTARAN",
        "ID_EVENT",
        "ID_PESERTA",    
        "ID_ORDER",         
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


    public function peserta()
    {
        return $this->belongsTo(Peserta::class,'ID_PESERTA');
    }

    public function check()
    {
        return $this->hasMany(Check::class,'ID_PENDAFTARAN');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'ID_ORDER');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'ID_EVENT');
    }
}
