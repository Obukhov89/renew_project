<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'module_name' => 'Заявка',
                'module_code' => 'request',
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                [
                    'module_code' => $module['module_code'],
                ],
                [
                    'module_name' => $module['module_name'],
                ]
            );
        }
    }
}
