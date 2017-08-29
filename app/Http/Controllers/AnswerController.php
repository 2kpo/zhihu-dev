<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;

class AnswerController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answer->create([
            'user_id' => Auth::id(),
            'question_id' => $question,
            'body' => $request->get('body')
        ]);
        $answer->question()->increment('answers_count');
        Auth::user()->increment('answers_count');
        return back();
    }
}
