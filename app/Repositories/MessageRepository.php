<?php
namespace App\Repositories;

use App\Message;
use Auth;

class MessageRepository {

    public function create($attribute)
    {
        return Message::create($attribute);
    }

    public function byId($message)
    {
        return Message::find($message);
    }

    public function byUserId()
    {
        $messages =  Message::where('from_user_id', user()->id)->orWhere('to_user_id', user()->id)->with(['fromUser', 'toUser'])->get();
        return $messages->groupBy('dialog_id');
    }

    public function byDialogId($dialog_id)
    {
        return Message::where('dialog_id', $dialog_id)->get();
    }

}