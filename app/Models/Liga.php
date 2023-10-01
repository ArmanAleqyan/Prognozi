<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function country_name()
    {
        return $this->belongsto(County::class, 'country_id');
    }
}
