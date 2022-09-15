<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evaluasi extends Model
{ 
    use HasFactory;
    protected $primaryKey = "ID_EVALUASI";
    protected $table = "evaluasi";
    protected $fillable = [    
        "DATA_JAWABAN",
        "ID_FORM_EVALUASI",       
        "ID_PENDAFTARAN",
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

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPeserta::class,'ID_PENDAFTARAN');
    }
}
