<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\SettingsResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class AuthController extends Controller
{
    public function login(LoginRequest $request) {

        $attributes = $request->validated();

        if (! $token = auth()->attempt($attributes)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /** @var User $user */
        $user = User::query()->where('id', auth()->id())->first();

        $user->update([
            'last_login_at' => Carbon::now(),
            'last_check_at' => Carbon::now(),
            'last_login_ip' => $request->getClientIp()
        ]);

        return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
    }

    public function register(RegisterRequest $request) {

        $attributes = $request->validated();

        User::query()->firstOrCreate([
            'email'    => $attributes['email'] ,
            'name'    => $attributes['name'] ,
            'password' => bcrypt($attributes['password']),
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function logout(Request $request) {
        try {

            /** @var User $user */
            $user = User::query()->where('id', auth()->id())->first();

            $user->update([
                'last_check_at' => null
            ]);

            auth()->logout();
        }
        catch (TokenExpiredException $exception)
        {
            return response()->json(['message' => 'Token Expired !'], 401);
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        return response()->json(['status' => 'success'], 200)->header('Authorization', auth()->refresh());
    }

    public function settings() {

        /** @var User $user */
        $user = User::query()->where('id', auth()->id())->with('roles','permissions')->firstOrFail();

        return SettingsResource::make($user);
    }

}
