<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentettValaszok extends Model
{
    //
    protected $table = 'mentes';

    protected $fillable = [
        'kerdoiv_id',
        'kerdes_id',
        'valasz',
        'tantargy_id',
        'szak_id',
        'neptunkod',
    ];
}
