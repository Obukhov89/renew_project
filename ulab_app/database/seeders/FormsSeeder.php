<?php

namespace Database\Seeders;

use App\Models\ModulesForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forms = [
            [
                'module_id' => 1,
                'form_name' => 'Заявка на испытания'
            ],
        ];

        foreach ($forms as $form) {
            ModulesForm::updateOrCreate(
                [
                    'module_id' => $form['module_id'],
                ],
                [
                    'form_name' => $form['form_name'],
                ]
            );
        }
    }
}
