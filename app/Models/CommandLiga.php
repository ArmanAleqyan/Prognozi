<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandLiga extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function ligas()
    {
        return $this->belongsto(Liga::class, 'liga_id');
    }
}
