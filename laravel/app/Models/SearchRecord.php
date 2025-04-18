<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchRecord extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'type'];
    protected $table = 'search_records'; 
    protected $primaryKey = 'id'; 
}

