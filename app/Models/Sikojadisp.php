<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sikojadisp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sikoja()
    {
        return $this->belongsTo(Sikoja::class);
    }

    public function files()
    {
        return $this->belongsTo(File::class);
    }
}
