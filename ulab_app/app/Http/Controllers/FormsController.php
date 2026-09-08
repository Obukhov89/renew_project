<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModulesForm;

class FormsController extends Controller
{
    public function getFieldsForm(Request $request)
    {
        $form = ModulesForm::with([
            'fields',
            'customFields',
        ])
            ->where('route', $request->route)
            ->first();

        if (!$form) {
            return response()->json([
                'message' => 'Форма не найдена'
            ], 404);
        }

        return response()->json($form);
    }
}
