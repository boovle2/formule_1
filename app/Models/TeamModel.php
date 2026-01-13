<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamModel extends Model
{
    protected $table = 'teams';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'points',
        'championships',
        'team_principal',
        'logo',
    ];

    public function drivers()
    {
        return $this->hasMany(DriverModel::class, 'team_id');
    }

    /**
     * Recalculate and persist total team points based on member drivers' standings.
     */
    public function refreshPoints()
    {
        $driverIds = $this->drivers()->pluck('id');
        $total = \App\Models\standings::whereIn('driver_id', $driverIds)->sum('points');
        $this->points = $total;
        $this->save();
        return $this;
    }
}
