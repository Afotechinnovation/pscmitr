<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Course;
use App\Models\Occupation;
use App\Models\Student;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\UserOccupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $student = Student::with('user')
            ->whereHas('user', function ($user){
                $user->where('id', Auth::user()->id);
            })
            ->first();
        $occupations = Occupation::all();
        $userOccupations = UserOccupation::where('user_id', $user->id)
                            ->get();
        $interests = Course::all();
        $userInterests = UserInterest::where('user_id', $user->id)
            ->get();
        if($request->packageId) {
            $packageId = $request->packageId;

        }else {

            $packageId = Null;
        }

//        return $occupations;

        return view('pages.user.profile.index', compact('user','student','occupations','userOccupations','userInterests','interests','packageId'));
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
        $student  = Student::where('user_id', Auth::user()->id)->first();
        $request->validate([
            'email' => 'required|unique:students,email,'.$id,
            'mobile' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|dimensions:max_width=300,max_height=300',
        ]);

        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->mobile = $request->input('mobile');
        $student->address = strip_tags($request->input('address'));
        $student->state_id = $request->input('state_id');
        $student->country_id = $request->input('country_id');
        $student->pin_code = $request->input('pin_code');
        $student->place = $request->input('place');
        $student->gender = $request->input('gender');
        $student->date_of_birth = $request->input('date_of_birth');

        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->gender = $request->input('gender');
        $user->dob = $request->input('date_of_birth');

        $user->save();

        $occupations = $request->occupations;
        $user->userOccupations()->sync($occupations);

        $interests = $request->interests;
        $user->userInterests()->sync($interests);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('image')->storeAs('student_profile', $filename, 'public');
            $student->image  = $filename;
        }

        $student->update();

        if($request->packageId) {
            info("packageId". $request->packageId);
            $user->is_profile_completed = true;
            $user->save();

            return redirect()->route('packages.show', $request->packageId)->with('success', 'Profile successfully updated');
        }

        return redirect()->route('user.profile.index')->with('success', 'Profile successfully updated');
    }

    public function ProfileUpdate(Request $request)
    {
        $student  = Student::where('user_id', Auth::user()->id)->first();

        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|dimensions:max_width=300,max_height=300',
        ]);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('image')->storeAs('student_profile', $filename, 'public');
            $student->image  = $filename;
        }

        $student->update();
        if($request->packageId) {
            return redirect()->route('user.profile.index', 'packageId='. $request->packageId)->with('success', 'Profile Picture successfully updated');
        }

        return redirect()->route('user.profile.index')->with('success', 'Profile Picture successfully updated');
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
}
