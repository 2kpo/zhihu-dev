<?php
namespace App\Repositories;

use App\Question;
use App\Topic;
use App\Answer;

class AnswerRepository {

    public function create($attribute)
    {
        return Answer::create($attribute);
    }

    public function byId($answer)
    {
        return Answer::find($answer);
    }

    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments','comments.user')->find($id);
        return $answer->comments;
    }
}