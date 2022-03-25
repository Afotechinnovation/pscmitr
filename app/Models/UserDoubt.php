<?php

namespace App\Models;


use App\Notifications\DoubtNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;

/**
 * App\Models\UserDoubt
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property string $doubt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereDoubt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $answer
 * @property int $question_id
 * @property-read mixed $status
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\Test $test
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDoubt whereQuestionId($value)
 */
class UserDoubt extends Model
{
    use HasFactory;
    protected $appends = [
        'status'
    ];

    public function send($doubt)
    {
        $notification = new DoubtNotification($doubt);

        $notifiable = new AnonymousNotifiable();

        $to_mail = $doubt->user->email;

        if($to_mail){
            $notifiable->route('mail', $to_mail);
        }

        $notifiable->notify($notification);
    }

    public function test() {
        return $this->belongsTo(Test::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute() {

        if(!$this->answer) {
            return 'Pending';
        }
        return 'Cleared';
    }
}
