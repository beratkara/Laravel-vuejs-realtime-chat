<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Berat Kara',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'İsmail Öcal',
                'email' => 'test@test.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Adem Kıvanç Filtekin',
                'email' => 'test2@test2.com',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $key => $value) {
            User::query()->updateOrCreate(
                [
                    'name' => $value['name']
                ],
                $value
            );
        }
    }
}
