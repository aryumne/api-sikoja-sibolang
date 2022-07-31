<?php

namespace App\Models;

use App\Models\Galery;
use App\Models\Street;
use App\Models\Village;
use App\Models\Category;
use App\Models\Sikojadisp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sikoja extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sikojadisp()
    {
        return $this->hasOne(Sikojadisp::class);
    }

    public function galery()
    {
        return $this->hasOne(Galery::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
