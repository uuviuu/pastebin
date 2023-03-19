<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Paste extends Model
{
    use SoftDeletes, AsSource, Filterable, Attachable, HasFactory;

    protected $table = 'pastes';

    protected $primaryKey = 'paste_hash';
    protected $keyType = 'string';

    protected $hidden = [
        'created_by_id',
        'deleted_at',
    ];

    protected $fillable = [
        'created_by_id',
        'expiration_time',
        'access',
        'paste_hash',
        'locale_lang',
        'paste',
        'complaint_message',
    ];

    public $dates = [
        'expiration_time',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function scopeByUser($query, $userId) {
        $query->where('created_by_id', $userId);

        return $query;
    }
}
