<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class standings extends Model
{
    protected $table = 'standings';

    protected $fillable = [
        'driver_id',
        'race_id',
        'placement',
        'points',
    ];
    public $timestamps = false;

    public function driver()
    {
        return $this->belongsTo(DriverModel::class, 'driver_id');
    }

    public function race()
    {
        return $this->belongsTo(RaceModel::class, 'race_id');
    }
}
