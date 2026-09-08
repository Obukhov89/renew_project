<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldsForm extends Model
{

    protected $fillable = [
        'module_id',
        'form_id',
        'type_field',
        'title_field',
        'name_field',
        'size_field',
        'precission_field',
        'is_required',
        'is_visible'
    ];

    public function form()
    {
        return $this->belongsTo(ModulesForm::class, 'form_id');
    }
}
