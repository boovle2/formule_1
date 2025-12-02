<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamModel extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'points',
        'championships',
        'team_principal',
        'logo',
    ];
}
