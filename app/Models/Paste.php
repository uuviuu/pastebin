<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property string $expiration_time
 * @property string $access
 * @property string $paste_hash
 * @property string $paste
 * @property int $created_by_id
 */
class Paste extends Model
{
    use SoftDeletes, AsSource, Filterable, Attachable, HasFactory;

    /**
     * @var string
     */
    protected $table = 'pastes';

    /**
     * @var string
     */
    protected $primaryKey = 'paste_hash';
    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_by_id',
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'created_by_id',
        'expiration_time',
        'access',
        'paste_hash',
        'lang',
        'paste',
        'complaint_message',
    ];

    /**
     * @var string[]
     */
    public $dates = [
        'expiration_time',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * @param $query
     * @param int $userId
     * @return mixed
     */
    public function scopeByUser($query, int $userId)
    {
        $query->where('created_by_id', $userId);

        return $query;
    }
}
