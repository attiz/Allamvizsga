<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Szak extends Model
{
    protected $table = 'szak';

    protected $fillable = [
        'szaknev',
    ];
}
