<?php
namespace App\Mailer;

use Naux\Mail\SendCloudTemplate;
use Mail;
class Mailer
{
    public function sendTo($data, $template, $email)
    {
        $content = new SendCloudTemplate($template, $data);
        Mail::raw($content, function ($message) use($email) {
            $message->from('2kpo@zhihu-dev.com', '2kpo');
            $message->to($email);
        });
    }
}