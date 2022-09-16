<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_EVENT";
    protected $table = "event";
    protected $fillable = [
        "ID_EO",
        "EVENT_TAB", 
        "NAMA_EVENT", 
        "TGL_MULAI", 
        "TGL_SELESAI", 
        "TGL_ACARA_MULAI", 
        "TGL_ACARA_SELESAI", 
        "WAKTU_SELESAI",
        "WAKTU_MULAI",
        "STATUS_EVENT", 
        "TOTAL_TIKET_BEREDAR",
        "EVENT_TAB", 
        "VISIBLE_EVENT",
        "SERTIFIKAT",
        "EVALUASI",
        "MODE_EVENT", 
        "BATAS_TRANSAKSI",
        "NAMA_LOKASI", 
        "LNG", 
        "LAT", 
        "URL", 
        "ADDRESS",
        "QRCODE", 
        "TOKEN", 
        "QNA",
        "BATAS_TIKET", 
        "KOMENTAR", 
        "ID_JENIS_ACARA", 
        "ID_KOTA"];

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
        return $this->hasMany(Tiket::class,"ID_EVENT");
    }

    public function eo()
    {
        return $this->hasMany(EO::class,"ID_EO");
    }

    public function jenisacara()
    {
        return $this->belongsTo(JenisAcara::class,'ID_JENIS_ACARA');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class,'ID_KOTA');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class,'ID_GENRE');
    }
}
