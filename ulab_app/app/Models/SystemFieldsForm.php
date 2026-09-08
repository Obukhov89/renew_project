<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFieldsForm extends Model
{

    public function form()
    {
        return $this->belongsTo(ModulesForm::class, 'form_id');
    }
}
