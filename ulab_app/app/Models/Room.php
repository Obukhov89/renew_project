<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'id_department',
        'id_assigned_room',
        'number',
        'name',
        'type',
        'room_place',
        'custom_fields'
    ];
}
