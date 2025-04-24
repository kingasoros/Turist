<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribe';

    public $timestamps = false;

    protected $fillable = ['user_id', 'city_id'];
}
