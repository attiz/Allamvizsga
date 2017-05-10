<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanar extends Model
{
    protected $table = 'tanar';


    protected $fillable = [
        'nev','felhasznalo','tanszek','fokozat'
    ];

    protected $hidden = [
        'jelszo',
        ];

}
