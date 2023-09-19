<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrognozAttr extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attr()
    {
        return $this->belongsTo(Prognoz::class, 'prognoz_id');
    }
}
