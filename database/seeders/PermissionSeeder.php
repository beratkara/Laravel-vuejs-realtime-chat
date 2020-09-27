<?php

namespace Database\Seeders;

use App\Entities\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Dashboardı Görebilir',
                'slug' => 'Dashboard Show'
            ],
        ];

        foreach ($permissions as $key => $value) {
            Permissions::query()->updateOrCreate(
                ['name' => $value['name']],
                ['slug' => Str::slug($value['slug'])]
            );
        }

    }
}
