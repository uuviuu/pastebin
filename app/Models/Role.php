<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'name',
        'permissions',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'permissions' => 'array',
    ];
}
