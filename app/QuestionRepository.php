<?php

namespace App;

use Prettus\Repository\Eloquent\BaseRepository;

class QuestionRepository extends BaseRepository
{
    function model()
        {
            return "App\\Question";
        }
}
