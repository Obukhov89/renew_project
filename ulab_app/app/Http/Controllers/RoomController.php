<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function journalRooms(){
        return Room::all();
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $saveData['id_department'] = 1;
        $saveData['id_assigned_room'] = 1;
        $saveData['number'] = $data['number'];
        $saveData['name'] = $data['name'];
        $saveData['type'] = $data['type'];
        $saveData['room_place'] = $data['address'];

        try {
            $newRoom = Room::create($saveData);

            return response()->json([
                'status' => 'success',
                'message' => 'Помещение успешно создано',
                'request_id' => $newRoom->id,
            ], 201);

        } catch (Throwable $error) {

            Log::error('Ошибка создания помещения', [
                'exception' => $error,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Не удалось создать помещение',
            ], 500);
        }
    }
}
