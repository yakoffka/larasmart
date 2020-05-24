<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Commutation
 *
 * @property int $id
 * @property int $relay_id
 * @property int $action_id
 * @property string $comment
 * @property string $type
 * @property string $start_at
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read BelongsTo $relay
 * @property-read BelongsTo $action
 *
 * @method static Builder|Commutation newModelQuery()
 * @method static Builder|Commutation newQuery()
 * @method static Builder|Commutation query()
 * @method static Builder|Commutation whereActionId($value)
 * @method static Builder|Commutation whereComment($value)
 * @method static Builder|Commutation whereCreatedAt($value)
 * @method static Builder|Commutation whereCreatorId($value)
 * @method static Builder|Commutation whereEditorId($value)
 * @method static Builder|Commutation whereId($value)
 * @method static Builder|Commutation whereRelayId($value)
 * @method static Builder|Commutation whereStartAt($value)
 * @method static Builder|Commutation whereStatus($value)
 * @method static Builder|Commutation whereType($value)
 * @method static Builder|Commutation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Commutation extends Model
{
    /**
     * @return BelongsTo
     */
    public function relay(): BelongsTo
    {
        return $this->belongsTo(Relay::class);
    }

    /**
     * @return BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }
}
