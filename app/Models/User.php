<?php

namespace App\Models;

use App\Entities\Contact;
use App\Entities\Message;
use App\Entities\Permissions;
use App\Entities\Roles;
use App\Entities\Room;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_check_at',
        'last_login_ip',
        'profile_picture',
        'profile_message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    protected $dates = [
        'email_verified_at',
        'last_check_at',
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphedByMany(
            Permissions::class,
            'model',
            'model_has_permissions',
            'model_id',
            'permission_id',
        );
    }

    public function roles(): MorphToMany
    {
        return $this->morphedByMany(
            Roles::class,
            'model',
            'model_has_roles',
            'model_id',
            'role_id'
        );
    }

    public function messages(): MorphToMany
    {
        return $this->morphedByMany(
            Message::class,
            'model',
            'model_has_messages',
            'model_id',
            'message_id',
        );
    }

    public function rooms(): MorphToMany
    {
        return $this->morphedByMany(
            Room::class,
            'model',
            'model_has_rooms',
            'model_id',
            'room_id'
        );
    }

    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_users',
            'model_id',
            'user_id'
        );
    }

    public function roomsAndMessages(): MorphToMany
    {
        return $this->rooms()->with('messages');
    }

    public function roomsAndUsers(): MorphToMany
    {
        return $this->rooms()->with('users');
    }

    public function rolesAndPermissions(): MorphToMany
    {
        return $this->roles()->with('permissions');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
