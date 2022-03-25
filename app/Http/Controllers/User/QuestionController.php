<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $questionId = $request->questionId;

        $search = $request->input('search');
        $query =  Question::with('options');

        if(!$search) {
            $searchQuestions =  $query;
        }

        $searchQuestions =  $query->where('question', 'LIKE', '%'. $search .'%')
                                ->orWhere('id', $questionId)
                                ->get();

        return view('pages.user.questions.index',compact('searchQuestions'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    function fetch(Request $request)
    {
        $search = $request->search;
        $questionId = $request->questionId;

        if($search == ''){
            $questions = Question::orderby('id','asc')->select('id','question')->get();
        }else{
            $questions = Question::orderby('id','asc')->select('id','question')->where('question', 'like', '%' .$search . '%')
                ->get();
        }

        $response = array();
        foreach($questions as $question){
            $data =  strip_tags($question->question);
            $response[] = array( "value" => $question->id, "label" => $data );
        }

        return response()->json($response);

    }
}
