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
        $messages = Message::where('from_user_id', user()->id)->orWhere('to_user_id', user()->id)->with(['fromUser' => function($query){
            return $query->select(['id', 'name', 'avatar']);
        }, 'toUser' => function($query){
            return $query->select(['id', 'name', 'avatar']);
        }])->get();
         return  $messages->groupBy('dialog_id');
        return $messages->each(function($item, $key){
            if ($this->dialogHasRead($key)){
                $item['unread'] = true;
            }
            $item['unread'] = false;
            return $item;
        });
    }

    public function byDialogId($dialog_id)
    {
        return Message::where('dialog_id', $dialog_id)->with(['fromUser' => function($query){
            return $query->select(['id', 'name', 'avatar']);
        }, 'toUser' => function($query){
            return $query->select(['id', 'name', 'avatar']);
        }])->latest()->get();
    }

    public function dialogHasRead($dialog_id)
    {
        return !! Message::where('dialog_id', $dialog_id)->where('to_user_id', user()->id)->where('has_read', 'F')->count();
    }

    public function OneByDialogId($dialog_id)
    {
        return Message::where('dialog_id', $dialog_id)->first();
    }
}