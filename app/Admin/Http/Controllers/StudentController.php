<?php

namespace App\Admin\Http\Controllers;

use App\Models\Course;
use App\Models\Occupation;
use App\Models\Student;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\UserOccupation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class   StudentController extends Controller
{
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Student::class);

        if (request()->ajax()) {
            $query = Student::query()->orderBy('id','DESC');

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                    if(request()->filled('filter.date') ) {

                        $dateRange = request('filter.date');
                        info($dateRange);
                        $dates = explode(' - ',$dateRange);

                        $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])).' 00:00:00');
                        $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])).' 00:00:00');

                        $query->where(function ($students) use ($start_date, $end_date) {
                            $students->whereDate('created_at', '>=', $start_date)
                                ->whereDate('created_at', '<=', $end_date);
                        });
                    }
                })
                ->editColumn('image', function ($student) {
                    if($student->image) {
                        return '<div><img  width="50" height="50" src="'.$student->image.'"></div>';
                    }else {
                        if($student->gender == 0) {
                            return '<div><img width="50" height="50" src="/web/images/female-avatar.jpeg"></div>';
                        }else{
                            return '<div><img width="50" height="50" src="/web/images/avatar.jpg"></div>';
                        }

                    }

                })
                ->editColumn('country_id', function ($student) {
                    if(!$student->country_id){
                        return '';
                    }
                    return $student->country->name;

                })

                ->editColumn('state_id', function ($student) {
                    if(!$student->state_id){
                        return '';
                    }
                    return $student->state->name;

                })
                ->editColumn('created_at', function ($student) {
                    return Carbon::parse($student->created_at)->format('d M Y ') ;
                })
                ->addColumn('time', function ($student) {
                    return Carbon::parse($student->created_at)->toTimeString();
                })
                ->addColumn('action', function ($student){
                    return view('admin::pages.students.action', compact('student'));
                })
                ->rawColumns(['action', 'image','created_at'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'image', 'name' => 'image', 'title' => 'Image'],
            ['data' => 'country_id', 'name' => 'country_id', 'title' => 'Country'],
            ['data' => 'state_id', 'name' => 'state_id', 'title' => 'State'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created Date'],
            ['name' => 'time', 'data' => 'time', 'title' => 'Created Time'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.students.index', compact('table'));
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
        $student =  Student::findOrFail($id);
        $user_id = $student->user_id;

        $user = User::findOrFail($user_id);

        // user_occupations

        $userOccupations = UserOccupation::where('user_id', $user_id)->get();
        $user_occupations = [];
        foreach ($userOccupations as $userOccupation)
        {
            $user_occupations[] = $userOccupation->occupation->name;
        }
        $user_occupation_names = collect($user_occupations)->all();
         $studentOccupations =  implode(', ', $user_occupation_names);
        // user interssts
        $userInterests = UserInterest::where('user_id', $user_id)->get();

        $user_interests = [];
        foreach ($userInterests as $userInterest)
        {
            $user_interests[] = $userInterest->course->name;
        }

        $user_interest_names = collect($user_interests)->all();
        $studentInterests =  implode(', ', $user_interest_names);

        $tableStudentTransaction = app(Builder::class)->columns([
            ['data' => 'package_id', 'name' => 'package_id', 'title' => 'Package'],
            ['data' => 'price', 'name' => 'price', 'title' => 'Price'],
            ['data' => 'gst_percentage', 'name' => 'gst_percentage', 'title' => 'GST Percentage'],
            ['data' => 'gst_amount', 'name' => 'gst_amount', 'title' => 'GST Amount'],
            ['data' => 'net_total', 'name' => 'net_total', 'title' => 'Total'],
            ['data' => 'package_expiry_date', 'name' => 'package_expiry_date', 'title' => 'Expiry Date'],
//          ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.students.transactions.index', $id))
            ->setTableId('table-student-transaction')
            ->orderBy(0, 'desc');

        $tableStudentTestResults = app(Builder::class)->columns([
            ['name' => 'test_id', 'data' => 'test_id', 'title' => 'Test'],
            ['name' => 'package_id', 'data' => 'package_id', 'title' => 'Package'],
            ['name' => 'attempt', 'data' => 'attempt', 'title' => 'No of Attempts'],
            ['name' => 'total_correct_answers', 'data' => 'total_correct_answers', 'title' => 'Correct Answers'],
            ['name' => 'total_wrong_answers', 'data' => 'total_wrong_answers', 'title' => 'Wrong Answers'],
            ['name' => 'total_marks', 'data' => 'total_marks', 'title' => 'Total Marks'],
//          ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.student.tests', $id))
            ->setTableId('table-student-tests')
            ->orderBy(0, 'desc');

        return view('admin::pages.students.show', compact('student','studentOccupations','user','studentInterests',
            'tableStudentTransaction','tableStudentTestResults'
           ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $user = User::findOrFail($student->user_id);

        $occupations = Occupation::all();
        $userOccupations = UserOccupation::where('user_id', $user->id)
                        ->get();
        $interests = Course::all();
        $userInterests = UserInterest::where('user_id', $user->id)
                         ->get();

        return view('admin::pages.students.edit', compact('student','occupations','userOccupations','interests','userInterests'));

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
        $student  = Student::where('user_id', $id)->first();

        $request->validate([
            'email' => 'required|unique:students,email,'.$id,
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

        $user = User::findOrFail($student->user_id);

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

        $this->authorize('update', $student);

        return redirect()->route('admin.students.index')->with('success', 'Student successfully updated');
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
