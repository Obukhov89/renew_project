<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'Создание заявки',
                'code' => 'request.create'
            ],
            [
                'name' => 'Просмотр заявки',
                'code' => 'request.view'
            ],
            [
                'name' => 'Редактирование заявки',
                'code' => 'request.update'
            ],
            [
                'name' => 'Удаление заявки',
                'code' => 'request.delete'
            ],
        ];


        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'code' => $permission['code']
                ],
                $permission
            );
        }
    }
}
