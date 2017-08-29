<?php
namespace App\Mailer;

use Auth;

class UserMailer extends Mailer
{
    public function UserFollowNotify($email)
    {
        $data = ['name' => Auth::guard('api')->user()->name ];

        $this->sendTo($data, 'user_follow_mail', $email);
    }
}