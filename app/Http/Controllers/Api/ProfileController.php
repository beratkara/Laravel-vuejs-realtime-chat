<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return SettingsResource
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = User::query()->where('id',auth()->id())->with('roles','permissions')->firstOrFail();

        if ($request->file())
        {
            foreach ($request->file() as $file)
            {
                $imageName = time().'.'.$file->extension();

                $file->move(public_path('images/users'), $imageName);

                $user->update([
                    'profile_picture' => $imageName
                ]);
            }
        }

        return SettingsResource::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return SettingsResource
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->only(['profile_message']);

        /** @var User $user */
        $user = User::query()->where('id', auth()->id())->firstOrFail();
        $user->update([
            'profile_message' => $attributes['profile_message']
        ]);

        return SettingsResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
