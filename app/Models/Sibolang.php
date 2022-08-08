<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Village;
use App\Models\Category;
use App\Models\Sibolangdisp;
use App\Models\GalerySibolang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sibolang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sibolangdisp()
    {
        return $this->hasOne(Sibolangdisp::class);
    }

    public function galery_sibolang()
    {
        return $this->hasMany(GalerySibolang::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
