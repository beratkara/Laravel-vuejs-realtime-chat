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
class Roles extends Model implements Transformable
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

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permissions::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_roles',
            'role_id',
            'model_id'
        );
    }

}
