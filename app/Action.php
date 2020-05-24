<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Action
 *
 * @property int $id
 * @property string $type
 * @property mixed $delays
 * @property int $creator_id
 * @property int|null $editor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read HasMany $commutations
 * @property-read BelongsTo $creator
 * @property-read BelongsTo $editor
 *
 * @method static Builder|Action newModelQuery()
 * @method static Builder|Action newQuery()
 * @method static Builder|Action query()
 * @method static Builder|Action whereCreatedAt($value)
 * @method static Builder|Action whereDelays($value)
 * @method static Builder|Action whereId($value)
 * @method static Builder|Action whereType($value)
 * @method static Builder|Action whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Action extends Model
{
    /**
     * @return HasMany
     */
    public function commutations(): HasMany
    {
        return $this->hasMany(Commutation::class);
    }

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
