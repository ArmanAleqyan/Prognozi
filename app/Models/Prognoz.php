<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prognoz extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function attr()
    {
        return $this->Hasmany(PrognozAttr::class, 'prognoz_id')->orderby('id','asc');
    }

    public function country_name()
    {
        return $this->belongsto(County::class, 'country_id');
    }
}
