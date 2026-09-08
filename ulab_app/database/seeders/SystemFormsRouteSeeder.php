<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemFormsRouteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_forms')
            ->where('form_name', 'Заявка на испытания')
            ->update([
                'route' => '/request/new',
            ]);
    }
}
