<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $student = Student::with('user')
            ->whereHas('user', function ($user){
                $user->where('id', Auth::user()->id);
            })
            ->first();

        return view('pages.dashboard.index', compact('user','student'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


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

    public function update(Request $request, $id)
    {
        //return $id;
       // $student_id = Auth::user()->id;
        $student  = Student::where('user_id', Auth::user()->id)->first();

       // return $student;

        $request->validate([

            'mobile' => 'required',
            'email' => 'required',
            'image'  => 'required|dimensions:width',
        ]);

        $student->name = $request->input('name');
        $student->mobile = $request->input('mobile');
        $student->email = $request->input('email');
        $student->address = $request->input('address');
        $student->state = $request->input('state');
        $student->country = $request->input('country');
        $student->pin_code = $request->input('pin_code');

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('image')->storeAs('student_profile', $filename, 'public');
            $student->image  = $filename;
        }

        $student->save();

        return redirect()->route('dashboard')->with('success', 'Profile successfully updated');

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
