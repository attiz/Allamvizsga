<?php
/**
 * Created by PhpStorm.
 * User: Zold Attila
 * Date: 20/11/2016
 * Time: 19:50
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Diak extends Model
{
    protected $table = 'diak';

    protected $fillable = [
        'neptun','szak_id'
    ];
}