<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins = [
            [
                'prefix_field' => 'Product',
                'prefix_value' => 'PD/2023/0000',
                'status' => 1,
                'company_id' => 1,
            ],
            [
                'prefix_field' => 'Lead',
                'prefix_value' => 'LD/2023/0000',
                'company_id' => 1,
                'status' => 1,
            ],
            [
                'prefix_field' => 'Deal',
                'prefix_value' => 'DL/2023/0000',
                'company_id' => 1,
                'status' => 1,
            ],
            [
                'prefix_field' => 'Invoice',
                'prefix_value' => 'INV/2023/0000',
                'company_id' => 1,
                'status' => 1,
            ]
        ];
        DB::table('prefix_settings')->insert($ins);
    }
}
