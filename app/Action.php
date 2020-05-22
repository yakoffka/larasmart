<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Action
 *
 * @property int $id
 * @property string $type
 * @property mixed $delays
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
    //
}
