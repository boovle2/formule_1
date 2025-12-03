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
}
