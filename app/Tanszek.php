<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanszek extends Model
{
    protected $table = 'tanszek';

    protected $fillable = [
        'nev',
    ];
}
