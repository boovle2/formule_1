<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SprintRaceModel extends Model
{
    protected $table = 'sprint_races';
    protected $fillable = ['race_id', 'name', 'date', 'location', 'laps', 'distance'];
    public $timestamps = false;
    

    public function race()
    {
        return $this->belongsTo(RaceModel::class, 'race_id');
    }
}
