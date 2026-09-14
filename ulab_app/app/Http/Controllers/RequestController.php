<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class RequestController extends Controller
{

    public function insertUpdate(Request $request)
    {
        $data = $request->all();

        // Получаем поля таблицы requests
        $tableFields = Schema::getColumnListing('requests');

        // Исключаем служебные поля БД
        $tableFields = array_diff(
            $tableFields,
            ['id', 'created_at', 'updated_at', 'custom_fields']
        );

        // Получаем поля, которые реально пришли из формы
        $formFields = array_keys($data);

        // Поля, которые являются колонками requests
        $systemFields = array_intersect($formFields, $tableFields);

        // Остальные поля считаем кастомными
        $customFields = array_diff($formFields, $tableFields);

        // Собираем данные для requests
        $systemData = [];

        foreach ($systemFields as $field) {
            $systemData[$field] = $data[$field];
        }

        // Статус новой заявки
        $systemData['id_status'] = 1;

        // Собираем значения кастомных полей
        $customData = [];

        foreach ($customFields as $field) {
            // Не сохраняем служебные параметры формы
            if (in_array($field, ['module_id', 'form_id'])) {
                continue;
            }

            $customData[$field] = $data[$field];
        }

        // JSONB
        $systemData['custom_fields'] = $customData;

        try {
            $newRequest = RequestModel::create($systemData);

            return response()->json([
                'status' => 'success',
                'message' => 'Заявка успешно создана',
                'request_id' => $newRequest->id,
            ], 201);

        } catch (Throwable $error) {

            Log::error('Ошибка создания заявки', [
                'exception' => $error,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Не удалось создать заявку',
            ], 500);
        }
    }
}
