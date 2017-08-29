<?php
namespace App\Repositories;

use App\Question;
use App\Topic;
use App\Comment;

class CommentRepository {

    public function create($attribute)
    {
        return Comment::create($attribute);
    }

}