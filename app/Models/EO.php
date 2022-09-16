<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EO extends Model
{
    use HasFactory;
    protected $primaryKey = "ID_EO";
    protected $table = "eo";
    protected $fillable = [
        "NAMA_EO",
        "LINK_WEB",
        "ALAMAT",
        "STATUS_EO",
        "ID_USER",
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

    public function user()
    {
        return $this->hasOne(User::class,'ID_USER','id');
    }
}
