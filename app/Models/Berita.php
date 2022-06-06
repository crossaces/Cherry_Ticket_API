<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "ID_BERITA";
    protected $table = "berita";
    protected $fillable = [
        "TGL_MULAI",
        "TGL_SELESAI",
        "JUDUL",
        "GAMBAR_BERITA",
        "DESKRIPSI",
        "ID_ADMIN",
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

    public function admin()
    {
        return $this->hasOne(Admin::class,'ID_ADMIN','ID_ADMIN');
    }
}
