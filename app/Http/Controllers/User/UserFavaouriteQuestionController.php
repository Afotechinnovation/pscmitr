<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserFavouriteQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavaouriteQuestionController extends Controller
{
    public function index()
    {
        $userFavouriteQuestions = UserFavouriteQuestion::where('user_id',Auth::user()->id)
            ->with('question')
            ->WhereHas('question')
            ->groupBy('question_id')
            ->get();

//        return $userFavouriteQuestions;

        return view('pages.user.favourite_questions.index',compact('userFavouriteQuestions'));
    }

    public function store(Request $request, UserFavouriteQuestion $userFavouiteQuestion)
    {
        $userFavouiteQuestion->question_id = $request->questionId;
        $userFavouiteQuestion->user_id =Auth::user()->id;
        //$userFavouiteQuestion->package_id = $request->packageId;
        $userFavouiteQuestion->test_result_id = $request->testResultId;
        $userFavouiteQuestion->test_id = $request->testId;
        $userFavouiteQuestion->save();
        return response()->json(true, 200);

    }

    public function destroy($id)
    {
        $userFavouiteQuestion = UserFavouriteQuestion::findOrFail($id);

        $userFavouiteQuestion->delete();

        return response()->json(true, 200);
    }
}
