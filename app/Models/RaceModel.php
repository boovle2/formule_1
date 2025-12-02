<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceModel extends Model
{
    protected $table = 'races';
    protected $fillable = ['name', 'date', 'location', 'laps', 'distance', 'image'];
}
