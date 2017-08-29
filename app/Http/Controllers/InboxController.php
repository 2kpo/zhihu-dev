<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use Auth;

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
         $this->message->create([
            'dialog_id' => request('dialog_id'),
            'body' => request('body'),
            'from_user_id' => user()->id,
            'to_user_id' => request('to_user_id')
            ]);
         return back();
     }
}
