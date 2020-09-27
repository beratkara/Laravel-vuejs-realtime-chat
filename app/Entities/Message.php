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
class Message extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'message',
        'attachment',
    ];

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(
            Room::class,
            'role_has_permissions',
            'message_id',
            'room_id'
        );
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_messages',
            'message_id',
            'model_id'
        );
    }

}
