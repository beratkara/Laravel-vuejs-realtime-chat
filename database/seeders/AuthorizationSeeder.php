<?php

namespace Database\Seeders;

use App\Entities\Permissions;
use App\Entities\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Roles $fullAuthority */
        $fullAuthority = Roles::query()->where('slug','member')->firstOrFail();
        $fullAuthority->permissions()->attach(Permissions::all());

        /** @var User $user */
        $user = User::query()->where('email','admin@admin.com')->first();
        $user->roles()->sync($fullAuthority);
        $user->permissions()->sync(Permissions::all());
        $fullAuthority->users()->attach($user);
    }
}
