<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Paste extends Model
{
    use AsSource, Filterable, Attachable, HasFactory;

    protected $table = 'pastes';

    protected $primaryKey = 'hash';

    protected $hidden = [
        'created_by_id',
        'deleted_at',
    ];

    protected $fillable = [
        'created_by_id',
        'expiration_time',
        'access',
        'hash',
        'locale_lang',
        'paste'
    ];

    public $dates = [
        'expiration_time',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

//    public function scopeByUser($query, $userId) {
//        return $query;
//    }
}
