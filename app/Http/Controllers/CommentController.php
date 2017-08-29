<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    protected $question;
    protected $answer;
    protected $comment;

    public function __construct(QuestionRepository $question, AnswerRepository $answer, CommentRepository $comment)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->comment = $comment;
    }

    public function question($id)
    {
        return $this->question->getQuestionCommentsById($id);
    }

    public function answer($id)
    {
        return $this->answer->getAnswerCommentsById($id);
    }

    public function store()
    {
        return $this->comment->create([
            'body' => request('body'),
            'user_id' => Auth::guard('api')->user()->id,
            'commentable_type' => $this->getModelNameByType(request('type')),
            'commentable_id' => request('model')
            ]);
    }

    public function getModelNameByType($model)
    {
        return $model === 'question' ?'App\Question':'App\Answer';
    }
}
