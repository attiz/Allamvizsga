<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerdes extends Model
{
    protected $table = 'kerdesek';

    protected $fillable = [
        'kerdes',
        'valasz1',
        'valasz2',
        'valasz3',
        'valasz4',
        'valasz5',
    ];
}
