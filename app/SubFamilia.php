<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubFamilia extends Model
{
    protected $fillable = [
        'id','nombre','id_familia',
    ];
}
