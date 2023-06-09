<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Platform\Models\User as Authenticatable;

/**
 * @property boolean $is_banned
 * @property string $role
 * @property array $permissions
 */
class User extends Authenticatable
{
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
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
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

    /**
     * @var string[]
     */
    protected $appends = ['role'];

    /**
     * @return string
     */
    public function getRoleAttribute(): string
    {
        return $this->role()->first()->name ?? 'user';
    }

    /**
     * @return HasMany
     */
    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class, 'created_by_id');
    }

    public function role(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    /**
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->role == 'client';
    }
}
