<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemFieldsFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $fields = [
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'select',
                'title_field' => 'Выберите материал',
                'name_field' => 'id_material',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'text',
                'title_field' => 'Заказчик',
                'name_field' => 'customer',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'email',
                'title_field' => 'E-mail',
                'name_field' => 'email',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'tel',
                'title_field' => 'Телефон',
                'name_field' => 'phone',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'text',
                'title_field' => 'Контактное лицо',
                'name_field' => 'contact_person',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'text',
                'title_field' => 'Номер партии',
                'name_field' => 'batch_number',
                'precission_field' => '',
                'is_required' => false,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'text',
                'title_field' => 'Основание для испытаний',
                'name_field' => 'basis_contest',
                'precission_field' => '',
                'is_required' => false,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'module_id' => 1,
                'form_id' => 1,
                'type_field' => 'number',
                'title_field' => 'Количество проб в партии',
                'name_field' => 'count_probes',
                'precission_field' => '',
                'is_required' => true,
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        foreach ($fields as $field) {
            DB::table('system_fields_forms')->insert($field);
        }
    }
}
