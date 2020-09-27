<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Permissions.
 *
 * @package namespace App\Entities;
 */
class Permissions extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Roles::class,
            'role_has_permissions',
            'permission_id',
            'role_id'
        );
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_permissions',
            'permission_id',
            'model_id'
        );
    }

}
