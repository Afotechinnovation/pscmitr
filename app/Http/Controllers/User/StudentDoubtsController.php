<?php

namespace App\Http\Controllers\User;

use App\Models\Question;
use App\Models\UserDoubt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentDoubtsController extends Controller
{

    public function index()
    {
        $studentDoubts = UserDoubt::with('test','question')
            ->where('user_id', Auth::id())
            ->orderBy('id','DESC')
            ->paginate(10);

        return view('pages.user.tests.doubts', compact('studentDoubts'));
    }

    public function store(Request $request)
    {
       $question = Question::where('id',$request->questionId)->first();

        $userDoubt = new UserDoubt();
        $userDoubt->user_id = Auth::id();
        $userDoubt->test_id = $request->testId;
        $userDoubt->question_id = $request->questionId;
        $userDoubt->course_id = $question->course_id;
        $userDoubt->subject_id = $question->subject_id;
        $userDoubt->doubt = $request->doubt;
        $userDoubt->save();

        return response()->json(true, 200);
    }

}
