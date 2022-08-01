<?php

namespace App\Models;

use App\Models\File;
use App\Models\Sikoja;
use App\Models\Instance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sikojadisp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sikoja()
    {
        return $this->belongsTo(Sikoja::class);
    }

    public function file()
    {
        return $this->hasMany(File::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }
}
