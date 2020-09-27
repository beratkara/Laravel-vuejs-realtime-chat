<?php

namespace Database\Seeders;

use App\Entities\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Member'
            ],
        ];

        foreach ($roles as $key => $value) {
            Roles::query()->updateOrCreate(
                ['name' => $value['name']],
                ['slug' => Str::slug($value['name'])]
            );
        }
    }
}
