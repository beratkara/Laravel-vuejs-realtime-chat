<?php

namespace App\Http\Controllers\Api\users;

use App\Filters\UsersFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = User::query()->where('id',auth()->id())->firstOrFail();
        $contacts = $user->contacts()->get();

        return UsersResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return UsersResource
     */
    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();

        /** @var User $user */
        $user = User::query()->where('id',auth()->id())->firstOrFail();
        /** @var User $currentUser */
        $remoteUser = User::query()->where('email',$attributes['email'])->firstOrFail();

        if ($user->id !== $remoteUser->id)
            $user->contacts()->attach($remoteUser);

        return UsersResource::make($user);
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
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
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
