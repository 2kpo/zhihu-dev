<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function store(Request $request)
    {
        $message = $this->message->create([
            'from_user_id' => user('api')->id,
            'to_user_id' => request('user'),
            'body' => request('body'),
            'dialog_id' => $this->getDialogId(request('user')),
            ]);
        if ($message) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function getDialogId($to_user_id)
    {

        $from_user_id = user('api')->id;
        return (string) $from_user_id > $to_user_id ? $to_user_id.'-'.$from_user_id : $from_user_id.'-'.$to_user_id;
    }
}
