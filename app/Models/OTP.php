<?php

namespace App\Models;

use App\Exceptions\InvalidOtpException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OTP
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OTP newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OTP newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OTP query()
 * @mixin \Eloquent
 */
class OTP extends Model
{
    use HasFactory;

    const ACTION_DEFAULT = 'default';

    protected $table = 'otps';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'verified_at',
    ];

//    public function __construct(array $attributes = [])
//    {
//        if(env('APP_ENV') != 'production'){
//            $this->code = 1234;
//        }
//        else{
//            $this->code = mt_rand(1000, 9999);
//        }
//        $this->action = self::ACTION_DEFAULT;
//
//        parent::__construct($attributes);
//    }

    /**
     * Find an otp by its token.
     *
     * @param $token
     * @return Otp
     */
    public static function findByToken($token)
    {
        $id = decrypt($token);

        return self::find($id);
    }

    public static function verify($token, $code, $action = self::ACTION_DEFAULT)
    {
        $otp = self::findByToken($token);

        if (is_null($otp)) {
           return false;
        }

        if ($otp->code != $code || $otp->action != $action) {
            return false;
        }

        if ($otp->isExpired() || $otp->isVerified()) {
            return false;
        }

        $otp->markAsVerified();

        return true;
    }

//    public function send()
//    {
//        $notification = new VerifyOtp($this);
//
//        $notifiable = new AnonymousNotifiable();
//
//        if($this->mobile){
//            $notifiable->route('sms', $this->mobile);
//        }
//        if($this->email){
//            $notifiable->route('mail', $this->email);
//        }
//
//        $notifiable->notify($notification);
//    }

    public function getToken()
    {
        return encrypt($this->id);
    }

    public function isVerified()
    {
        return !is_null($this->verified_at);
    }

    public function isExpired()
    {
        return Carbon::now()->gt($this->updated_at->addMinutes(10));
    }

    public function markAsVerified($save = true)
    {
        $this->verified_at = Carbon::now();

        if ($save) {
            $this->save();
        }
    }

}
