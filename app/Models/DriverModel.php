<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverModel extends Model
{
    protected $table = 'drivers';
    protected $fillable = ['team_id', 'Fname', 'Lname', 'number', 'points', 'image'];
    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo(TeamModel::class, 'team_id');
    }

    public function standings()
    {
        return $this->hasMany(standings::class, 'driver_id');
    }

    /**
     * Recalculate and persist total points for this driver (single source of truth).
     */
    public function refreshPoints()
    {
        $total = $this->standings()->sum('points');
        $this->points = $total;
        $this->save();
        return $this;
    }
}
