<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tantargy extends Model
{
    protected $table = 'tantargy';

    protected $fillable = [
        'nev',
    ];
}
