<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerdoiv extends Model
{
    protected $table = 'kerdoiv';

    protected $fillable = [
        'kerdoiv_id',
        'kerdes_id',
        'tanar_id',
        'tantargy_id',
        'aktiv'
    ];
}
