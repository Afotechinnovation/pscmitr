<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $mobile
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $role
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @property string|null $image
 * @property string|null $provider
 * @property int|null $provider_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @property string $pin_number
 * @property string|null $last_login_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserFavouriteQuestion[] $favouriteQuestions
 * @property-read int|null $favourite_questions_count
 * @property-read mixed $purchased_packages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestResult[] $test_results
 * @property-read int|null $test_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePinNumber($value)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_STUDENT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'purchased_packages','purchased_users'
    ];

    public function getPurchasedPackagesAttribute()
    {
        if( !Auth::id() ){
            return [];
        }

        $user_packages = Transaction::where('user_id', Auth::id())
            ->pluck('package_id')
            ->toArray();

        return array_unique( $user_packages );
    }

    public function getPurchasedUsersAttribute()
    {
        if( !Auth::id() ){
            return [];
        }

        $purchaseUsers = Transaction::where('user_id', Auth::id())
            ->pluck('user_id')
            ->toArray();

        return array_unique( $purchaseUsers );
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'transactions');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function test_results()
    {
        return $this->hasMany(TestResult::class);
    }

    public function favouriteQuestions()
    {
        return $this->hasMany(UserFavouriteQuestion::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function package_rating()
    {
        return $this->hasOne(PackageRating::class);
    }
    public function test_rating()
    {
        return $this->hasOne(TestRating::class);
    }

    public function userInterests()
    {
        return $this->belongsToMany(Course::class, 'user_interests', 'user_id', 'course_id');
    }

    public function userOccupations()
    {
        return $this->belongsToMany(Occupation::class, 'user_occupations', 'user_id', 'occupation_id');
    }


}
