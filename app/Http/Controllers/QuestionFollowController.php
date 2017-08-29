<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Repositories\QuestionRepository;

class QuestionFollowController extends Controller
{
    protected $question;
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }
    public function follows($question)
    {
        Auth::user()->followThis($question);
        return back();
    }

    public function isFollowedThisQuestion(Request $request)
    {
        if (user('api')->isfollowed($request->get('question')) ){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisQuestion(Request $request, QuestionRepository $question)
    {
        $flag = user('api')->followThis($request->get('question'));
        $question = $this->question->byId($request->get('question'));
        if (count($flag['detached']) > 0) {
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        } else{
            $question->increment('followers_count');
            return response()->json(['followed' => true]);
        }
    }
}
