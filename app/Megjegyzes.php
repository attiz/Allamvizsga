<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Megjegyzes extends Model
{
    //
    protected $table = 'megjegyzes';

    protected $fillable = [
        'neptunkod',
        'megjegyzes',
    ];
}
