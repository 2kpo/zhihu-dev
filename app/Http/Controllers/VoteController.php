<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AnswerRepository;
use Auth;

class VoteController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function hasVoted(Request $request, $answer)
    {
        $user = Auth::guard('api')->user();
        if ($user->hasVoted($answer))
            return response()->json(['voted' => true]);
        return response()->json(['voted' => false]);
    }

    public function vote(Request $request)
    {
        $user = Auth::guard('api')->user();
        $voted = $user->voteThis($request->get('answer'));
        $answer = $this->answer->byId($request->get('answer'));
        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');
            return response()->json(['voted' => true]);
        } else{
            $answer->decrement('votes_count');
            return response()->json(['voted' => false]);
        }
    }
}
