<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\SystemFieldsForm;
use App\Models\CustomFieldsForm;
use Illuminate\Http\Request;

class FormsConstructorController extends Controller
{
    public function getAllModuleForms()
    {
        $modules = Module::with([
            'forms.fields',
            'forms.customFields',
        ])
            ->orderBy('module_name')
            ->get();

        return response()->json($modules);
    }

    public function updateFormFields(Request $request)
    {
        foreach ($request->fields as $field) {

            /*
             * Системное поле
             */
            if ($field['is_system']) {

                SystemFieldsForm::where('id', $field['id'])
                    ->update([
                        'title_field' => $field['title_field'],
                        'is_required' => $field['is_required'],
                        'is_visible'  => $field['is_visible'],
                    ]);

                continue;
            }

            /*
             * Новое кастомное поле
             */
            if ($field['is_new']) {

                CustomFieldsForm::create([
                    'module_id'        => $field['module_id'],
                    'form_id'          => $field['form_id'],
                    'type_field'       => $field['type_field'],
                    'title_field'      => $field['title_field'],
                    'name_field'       => $field['name_field'],
                    'size_field'       => $field['size_field'] ?? '',
                    'precission_field' => $field['precission_field'] ?? '',
                    'is_required'      => $field['is_required'] ?? false,
                    'is_visible'       => $field['is_visible'] ?? true,
                ]);

                continue;
            }

            /*
             * Существующее кастомное поле
             */
            CustomFieldsForm::where('id', $field['id'])
                ->update([
                    'title_field'      => $field['title_field'],
                    'type_field'       => $field['type_field'],
                    'size_field'       => $field['size_field'] ?? '',
                    'precission_field' => $field['precission_field'] ?? '',
                    'is_required'      => $field['is_required'] ?? false,
                    'is_visible'       => $field['is_visible'] ?? true,
                ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
