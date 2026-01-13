<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualifyingRaceModel extends Model
{
    protected $table = 'qualifying_races';

    protected $fillable = [
        'race_id',
        'name',
        'date',
    ];

    public $timestamps = false;

    public function results()
    {
        return $this->hasMany(QualifyingResult::class, 'qualifying_race_id');
    }

    public function race()
    {
        return $this->belongsTo(RaceModel::class, 'race_id');
    }
}
