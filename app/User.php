<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

        public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    public function follow()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }
    //获得followed' followers 既model为followed
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }
    //获得follower' followeds 既model为follower
    public function followedUsers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follow()->toggle($question);
    }

    public function followThisUser($user)
    {
        return $this->followedUsers()->toggle($user);
    }

    public function isfollowed($question)
    {
        return !! $this->follow()->where('question_id', $question)->count();
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteThis($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVoted($answer)
    {
        return !! $this->votes()->where('answer_id', $answer)->count();
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $data = ['url' => url('password/reset', $token),];
        (new UserMailer())->sendTo($data,'zhihu_reset_password',$this->email);
    }
}
