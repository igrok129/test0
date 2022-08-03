<?php

namespace App\Models;

use Database\Factories\TimeZoneFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static TimeZoneFactory  factory(...$parameters)
 * @method static Builder|TimeZone newModelQuery()
 * @method static Builder|TimeZone newQuery()
 * @method static Builder|TimeZone query()
 * @method static Builder|TimeZone whereCreatedAt($value)
 * @method static Builder|TimeZone whereId($value)
 * @method static Builder|TimeZone whereName($value)
 * @method static Builder|TimeZone whereUpdatedAt($value)
 *
 * @mixin Model
 */
class TimeZone extends Model
{
    use HasFactory;
}
