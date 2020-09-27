<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Roles.
 *
 * @package namespace App\Entities;
 */
class Room extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'group',
        'user_id',
    ];

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(
            Message::class,
            'room_has_messages',
            'room_id',
            'message_id'
        );
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_rooms',
            'room_id',
            'model_id'
        );
    }

    public function usersAndMessages(): MorphToMany
    {
        return $this->users()->with('messages');
    }

    public function messagesAndUser(): BelongsToMany
    {
        return $this->messages()->orderBy('id','desc')->with('users');
    }

    public function remoteUser(): MorphToMany
    {
        return $this->users()->where('id','<>',auth()->id());
    }

}
