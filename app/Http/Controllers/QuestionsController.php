<?php

namespace App\Http\Controllers;

use App\Question;
use App\Http\Requests\StoreQuestionRequest;
use Auth;
use Illuminate\Http\Request;
use App\Topic;
class QuestionsController extends Controller
{
    protected $repository;
    public function __construct(QuestionRepository $repository)
    {
        $this->middleware('auth')->except('index', 'show');
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topics = $this->normalizeTopic($request->get('topics'));
        $data = [
        'title' => $request->title,
        'body' => $request->body,
        'user_id' => Auth::id()
        ];
        // Storage::putFile('img', $request->file('img'));
        $question = Question::create($data);
        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic){
            if (is_numeric($topic)) {
                return (int) $topic;
            }
            $newTopic = Topic::create(['name' => $topic, 'questions_count' =>1 ]);
            return $newTopic->id;
        })->toArray();
    }
}
