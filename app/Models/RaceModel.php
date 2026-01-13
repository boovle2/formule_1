<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceModel extends Model
{
    protected $table = 'races';
    protected $fillable = ['name', 'date', 'location', 'laps', 'distance', 'image'];
    public $timestamps = false;

    public function standings()
    {
        return $this->hasMany(\App\Models\standings::class, 'race_id');
    }

    /**
     * Results for the main race (session_type = 'race')
     */
    public function raceResults()
    {
        return $this->standings()->where('session_type', 'race')->orderBy('placement');
    }

    /**
     * Sprint results grouped by session_id (each sprint race)
     */
    public function sprintResultsGrouped()
    {
        return $this->standings()->where('session_type', 'sprint')->orderBy('session_id')->orderBy('placement')->get()->groupBy('session_id');
    }
}
