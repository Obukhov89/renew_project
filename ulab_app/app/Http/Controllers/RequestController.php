<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class RequestController extends Controller
{

    public function insertUpdate(Request $request)
    {

        $validated = $request->validate([
            'id_material'     => ['required', 'integer'],
            'email'           => ['nullable', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'contact_person'  => ['nullable', 'string', 'max:255'],
            'test_basis'      => ['nullable', 'string'],
            'batch_number'    => ['nullable', 'string', 'max:255'],
            'sample_quantity' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['id_status'] = 1;

        try {
            $newRequest = RequestModel::create($validated);
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
