<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'module_permissions');
    }
}
