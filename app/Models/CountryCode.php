<?php

namespace App\Models;

use Database\Factories\CountryCodeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property string $country_name
 * @property string $cca2
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static CountryCodeFactory  factory(...$parameters)
 * @method static Builder|CountryCode newModelQuery()
 * @method static Builder|CountryCode newQuery()
 * @method static Builder|CountryCode query()
 * @method static Builder|CountryCode whereCca2($value)
 * @method static Builder|CountryCode whereCountryName($value)
 * @method static Builder|CountryCode whereCreatedAt($value)
 * @method static Builder|CountryCode whereId($value)
 * @method static Builder|CountryCode whereUpdatedAt($value)
 *
 * @mixin Model
 */
class CountryCode extends Model
{
    use HasFactory;

    protected $guarded = [];
}
