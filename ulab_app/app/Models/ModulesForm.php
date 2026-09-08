<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulesForm extends Model
{
    protected $table = 'system_forms';
    protected $fillable = ['module_id', 'form_name'];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function fields()
    {
        return $this->hasMany(SystemFieldsForm::class, 'form_id');
    }

    public function customFields()
    {
        return $this->hasMany(CustomFieldsForm::class, 'form_id');
    }
}
