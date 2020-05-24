<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Relay
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $device_id
 * @property int $number
 * @property boolean $expected_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read BelongsTo $device
 *
 * @method static Builder|Relay newModelQuery()
 * @method static Builder|Relay newQuery()
 * @method static Builder|Relay query()
 * @method static Builder|Relay whereCreatedAt($value)
 * @method static Builder|Relay whereDescription($value)
 * @method static Builder|Relay whereDeviceId($value)
 * @method static Builder|Relay whereId($value)
 * @method static Builder|Relay whereName($value)
 * @method static Builder|Relay whereNumber($value)
 * @method static Builder|Relay whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Relay extends Model
{
    protected $fillable = [
        'name',
        'description',
        'device_id',
        'number',
        'expected_status',
    ];

    /**
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
