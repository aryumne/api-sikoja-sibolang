<?php

namespace App\Models;

use App\Models\Instance;
use App\Models\Sibolang;
use App\Models\FileSibolangdisp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sibolangdisp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sibolang()
    {
        return $this->belongsTo(Sibolang::class);
    }

    public function file_sibolangdisp()
    {
        return $this->hasMany(FileSibolangdisp::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }
}
