<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Device
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $hid
 * @property int $number_relay
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read hasMany $relays
 *
 * @method static Builder|Device newModelQuery()
 * @method static Builder|Device newQuery()
 * @method static Builder|Device query()
 * @method static Builder|Device whereCreatedAt($value)
 * @method static Builder|Device whereDescription($value)
 * @method static Builder|Device whereHid($value)
 * @method static Builder|Device whereId($value)
 * @method static Builder|Device whereName($value)
 * @method static Builder|Device whereNumberRelay($value)
 * @method static Builder|Device whereOnlineStatus($value)
 * @method static Builder|Device whereUpdatedAt($value)
 * @mixin Eloquent
 * @package App
 */
class Device extends Model
{
    protected $fillable = [
        'name',
        'hid',
        'number_relay',
        'description',
        'status',
    ];

    public string $status = 'offline';

    /**
     * Get the relay of this device
     *
     * @return HasMany
     */
    public function relays(): hasMany
    {
        return $this->hasMany(Relay::class);
    }
}
