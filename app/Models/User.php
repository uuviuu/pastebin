<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Platform\Models\User as Authenticatable;

/**
 * @property boolean $is_banned
 * @property string $role
 */
class User extends Authenticatable
{
//    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'is_banned',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

//    protected $dates = [
//        'deleted_at',
//    ];

    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class, 'created_by_id');
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isClient(): bool
    {
        return $this->role == 'client';
    }
//    api_token = str_random(60);
}
