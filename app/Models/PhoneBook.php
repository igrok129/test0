<?php

namespace App\Models;

use Database\Factories\PhoneBookFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int         $id
 * @property string      $name
 * @property string|null $second_name
 * @property string      $phone_number
 * @property string|null $country_code
 * @property string|null $timezone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static PhoneBookFactory  factory(...$parameters)
 * @method static Builder|PhoneBook newModelQuery()
 * @method static Builder|PhoneBook newQuery()
 * @method static Builder|PhoneBook query()
 * @method static Builder|PhoneBook whereCountryCode($value)
 * @method static Builder|PhoneBook whereCreatedAt($value)
 * @method static Builder|PhoneBook whereId($value)
 * @method static Builder|PhoneBook whereName($value)
 * @method static Builder|PhoneBook wherePhoneNumber($value)
 * @method static Builder|PhoneBook whereSecondName($value)
 * @method static Builder|PhoneBook whereTimezone($value)
 * @method static Builder|PhoneBook whereUpdatedAt($value)
 *
 * @mixin Model
 */
class PhoneBook extends Model
{
    use HasFactory;

    protected $table = 'phone_book';

    protected $guarded = [];
}
