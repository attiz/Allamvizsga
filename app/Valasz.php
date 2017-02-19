<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valasz extends Model
{
     protected $table = 'valaszok';

    protected $fillable = [
        'kerdoiv_id',
        'kerdes_id',
        'valasz',
        'tantargy_id',
    ];
}
