<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_permissions');
    }
}
