<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chirp whereUserId($value)
 * @mixin \Eloquent
 */
class Chirp extends Model
{
    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //
}
