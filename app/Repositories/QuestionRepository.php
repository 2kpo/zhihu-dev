<?php
namespace App\Repositories;

use App\Question;
use App\Topic;

class QuestionRepository {

    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id', $id)->with(['topics', 'answers'])->first();
    }

    public function create($attribute)
    {
        return Question::create($attribute);
    }

    public function byId($id)
        {
            return Question::find($id);
        }

    public function getQuestionFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function getQuestionCommentsById($id)
    {
        $question = Question::with('comments','comments.user')->find($id);
        return $question->comments;
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic){
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            $topic_id = Topic::where('name', $topic)->first()->id;
            if (!empty($topic_id))
                return $topic_id;
            $newTopic = Topic::create(['name' => $topic, 'questions_count' =>1 ]);
            return $newTopic->id;
        })->toArray();
    }
}