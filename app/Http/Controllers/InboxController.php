<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use Auth;
use App\Notifications\NewMessageNotification;

class InboxController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->middleware('auth');
        $this->message = $message;
    }

    public function index()
    {
        $messages = $this->message->byUserId();
        return view('inbox.index', compact('messages'));
    }

    public function show($dialog_id)
    {
        $messages = $this->message->byDialogId($dialog_id);
        $messages->markAsRead();
        return view('inbox.show', compact('messages'));
    }

    public function store()
    {
        $newMessage = $this->message->create([
            'dialog_id' => request('dialog_id'),
            'body' => request('body'),
            'from_user_id' => user()->id,
            'to_user_id' => $this->getToUserId(request('dialog_id'))
            ]);
        $newMessage->toUser->notify(new NewMessageNotification($newMessage));
         return back();
     }

     public function getToUserId($dialog_id)
     {
         $dialog = $this->message->OneByDialogId($dialog_id);
         return $dialog->to_user_id == user()->id ?$dialog->from_user_id:$dialog->to_user_id;
     }
}
