<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orak extends Model
{
    protected $table = 'tanar_tantargy';

    protected $fillable = [
        'tanar_id',
        'tantargy_id',
        'szak_id',
        'evfolyam',
        'felev',
        'aktiv',
    ];
}
