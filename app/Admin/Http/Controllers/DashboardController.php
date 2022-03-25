<?php

namespace App\Admin\Http\Controllers;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\Course;
use App\Models\ExamNotification;
use App\Models\Package;
use App\Models\PackageRating;
use App\Models\Question;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserDoubt;
use App\Models\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $gender = null;
        $test = null;
        $total_users  = User::all();

        $subscribers = User::with('transactions')
            ->whereHas('transactions')
            ->get();
      //    return $subscribers;
        $total_subscriptions = Transaction::all();
        $dormant_subscriber_count = User::whereDate('last_login_at', '<=', Carbon::now()->subDays(30))
            ->with('transactions')
            ->whereHas('transactions')
            ->count();

        // visits in page
        $tests = Test::all();
        $testCounts = Test::all();
        $courses= Course::all();
        $blogs = Blog::all();
        $admins = Admin::all();
        $exam_notifications = ExamNotification::all();
        $videos = Video::all();
        $user_doubts = UserDoubt::where('answer', '!=', null)->get();
        //return $user_doubts;


        // percentage of increment
        $current_month_user_count  = User::whereMonth('created_at', '=', Carbon::now()->month)->count();
        $last_month_user_count  = User::whereMonth('created_at',  '=', Carbon::now()->subMonth()->month)->count();
        if($last_month_user_count == 0){
            $user_percentage_of_increment = 0;
        }else {

            $user_percentage_of_increment = (($current_month_user_count - $last_month_user_count)/$last_month_user_count)*100;
        }

        if($user_percentage_of_increment < 0) {

            $user_percentage_of_increment = 0;
        }else {
            $user_percentage_of_increment = $user_percentage_of_increment;

        }

        $current_month_subscriber_count  = User::with('transactions')
            ->whereHas('transactions')
            ->whereMonth('created_at', '=', Carbon::now()->month)->count();
        $last_month_subscriber_count  = User::with('transactions')
            ->whereHas('transactions')
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
       // return $last_month_subscriber_count;

        if($last_month_subscriber_count == 0){
            $subscriber_percentage_of_increment = 0;
        }
        else{
            $subscriber_percentage_of_increment = (($current_month_subscriber_count - $last_month_subscriber_count)/$last_month_subscriber_count)*100;

        }

        if($subscriber_percentage_of_increment < 0) {

            $subscriber_percentage_of_increment = 0;
        }else {
            $subscriber_percentage_of_increment = $subscriber_percentage_of_increment;

        }
        $dormantUserPercentageOfIncrement = $user_percentage_of_increment - $subscriber_percentage_of_increment;

        if($dormantUserPercentageOfIncrement < 0) {

            $dormant_user_percentage_of_increment = 0;

        }else{
            $dormant_user_percentage_of_increment = $dormantUserPercentageOfIncrement;
        }

        $current_month_subscription_count = Transaction::whereMonth('created_at', '=', Carbon::now()->month)->count();
        $last_month_subscription_count  = Transaction::whereMonth('created_at',  '=', Carbon::now()->subMonth()->month)->count();
       // return $last_month_subscription_count;
        if($last_month_subscription_count == 0){

            $subscription_percentage_of_increment = 0;
        } else {

            $subscription_percentage_of_increment = (($current_month_subscription_count - $last_month_subscription_count)/$last_month_subscription_count)*100;
        }

        if($subscription_percentage_of_increment < 0) {

            $subscription_percentage_of_increment = 0;

        }else {
            $subscription_percentage_of_increment = $subscription_percentage_of_increment;
        }

        $lastMonthDormantSubscriberCount = User::whereDate('last_login_at', '<=', Carbon::now()->subDays(30)->month())
            ->with('transactions')
            ->whereHas('transactions')
            ->count();

//        return $lastMonthDormantSubscriberCount;

        // rating

        $package_rating_five = PackageRating::where('rating', '5')->count();
        $package_rating_four = PackageRating::where('rating', '4')->count();
        $package_rating_three = PackageRating::where('rating', '3')->count();
        $package_rating_two = PackageRating::where('rating', '2')->count();
        $package_rating_one = PackageRating::where('rating', '1')->count();

//        if($request->test) {
//
//            $test = $request->test;
//
//            $total_users = User::with(['test_results' => function ( $test_results ) use( $test ) {
//                            $test_results->where('test_id', $test);
//                            }])
//                ->whereHas('test_results', function ( $test_results ) use($test) {
//                            $test_results->where('test_id', $test);
//                         })
//                ->get();
//
//            $subscribers = $total_users;
//
//            $dormant_subscriber_count = User::whereDate('last_login_at', '<=', Carbon::now()->subDays(30))
//                ->with('test_results')
//                ->whereHas('test_results', function ( $test_results ) use( $test ) {
//                    $test_results->where('test_id', $test);
//                })
//                ->count();
//
//        }



    if($request->age || $request->gender != null || $request->country_id || $request->state_id ||
        $request->date_range || $request->course_id || $request->test) {


        $age = $request->age;
        $gender = $request->gender;
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $course_id = $request->course_id;
        $dateRange = $request->date_range;
        $test = $request->test;


        $user_date_of_birth = Carbon::now()->subYear($age)->format('Y-m-d');

        $total_users = User::with('students','transactions','test_results');
        $subscribers = User::with('transactions.user.students');
        $dormant_subscriber = User::with('transactions.user.students');
        $total_subscriptions = Transaction::with('user.students');

        if ($age) {
            $total_users->whereHas('students', function ($total_users) use ($user_date_of_birth) {
                $total_users->where('date_of_birth', $user_date_of_birth);
            });

            $subscribers->whereHas('transactions.user.students', function ($students) use ($user_date_of_birth) {
                $students->where('date_of_birth', $user_date_of_birth);
            });

            $dormant_subscriber->whereHas('transactions.user.students', function ($user) {
                $user->whereDate('last_login_at', '<=', Carbon::now()->subDays(30));

            })
                ->whereHas('transactions.user.students', function ($students) use ($user_date_of_birth) {
                    $students->where('date_of_birth', $user_date_of_birth);
                });

            $total_subscriptions->whereHas('user.students', function ($students) use ($user_date_of_birth) {
                $students->where('date_of_birth', $user_date_of_birth);
            });
        }

        if($gender == 'male') {
            $genderValue = 1;
        }else{
            $genderValue = 0;
        }
        if ($gender) {

            $total_users->whereHas('students', function ($total_users) use ($genderValue) {
                $total_users->where('gender', $genderValue);
            });
            $subscribers->whereHas('transactions.user.students', function ($students) use ($genderValue) {
                $students->where('gender', $genderValue);
            });
            $dormant_subscriber->whereHas('transactions.user.students', function ($user) {
                $user->whereDate('last_login_at', '<=', Carbon::now()->subDays(30));

            })
                ->whereHas('transactions.user.students', function ($students) use ($genderValue) {
                    $students->where('gender', $genderValue);
                });

            $total_subscriptions->whereHas('user.students', function ($students) use ($genderValue) {
                $students->where('gender', $genderValue);
            });
        }

        if ($country_id) {
            $total_users->whereHas('students', function ($total_users) use ($country_id) {
                $total_users->where('country_id', $country_id);
            });

            $subscribers->whereHas('transactions.user.students', function ($subscribers) use ($country_id) {
                $subscribers->where('country_id', $country_id);

            });

            $dormant_subscriber->whereHas('transactions.user.students', function ($user) {
                $user->whereDate('last_login_at', '<=', Carbon::now()->subDays(30));

            })
                ->whereHas('transactions.user.students', function ($students) use ($country_id) {
                    $students->where('country_id', $country_id);
                });

            $total_subscriptions->whereHas('user.students', function ($students) use ($country_id) {
                $students->where('country_id', $country_id);
            });
        }
        if ($state_id) {
            $total_users->whereHas('students', function ($total_users) use ($state_id) {
                $total_users->where('state_id', $state_id);

            });

            $subscribers->whereHas('transactions.user.students', function ($students) use ($state_id) {
                $students->where('state_id', $state_id);
            });

            $dormant_subscriber->whereHas('transactions.user.students', function ($user) {
                $user->whereDate('last_login_at', '<=', Carbon::now()->subDays(30));

            })
                ->whereHas('transactions.user.students', function ($students) use ($state_id) {
                    $students->where('state_id', $state_id);
                });

            $total_subscriptions->whereHas('user.students', function ($students) use ($state_id) {
                $students->where('state_id', $state_id);
            });
        }
        if($dateRange) {

            $dates = explode(' - ',$dateRange);
            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])).' 00:00:00');
            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])).' 00:00:00');

            $total_users->whereBetween('created_at', array($start_date, $end_date));

            $dormant_subscriber->whereHas('transactions.user.students', function ($user) {
                $user->whereDate('last_login_at', '<=', Carbon::now()->subDays(30));

            })
                ->whereHas('transactions', function ($students) use ( $start_date, $end_date) {
                    $students->whereBetween('created_at', array($start_date, $end_date));
                });

            // dormant subscriber

            $subscribers->whereHas('transactions', function ($students) use ( $start_date, $end_date) {
                $students->whereBetween('created_at', array($start_date, $end_date));
            });

            $total_subscriptions->whereBetween('created_at', array($start_date, $end_date));

            $testCounts = Test::whereBetween('created_at', array($start_date, $end_date))->get();
            $blogs = Blog::whereBetween('created_at', array($start_date, $end_date))->get();
            $courses = Course::whereBetween('created_at', array($start_date, $end_date))->get();
            $videos = Video::whereBetween('created_at', array($start_date, $end_date))->get();
            $exam_notifications = ExamNotification::whereBetween('created_at', array($start_date, $end_date))->get();
            $admins = Admin::whereBetween('created_at', array($start_date, $end_date))->get();

        }

        if($course_id) {

            $total_users->whereHas('transactions.package', function ( $transaction_packages ) use( $course_id ) {
                    $transaction_packages->where('course_id', $course_id);
                });

            $subscribers = $total_users;

            $dormant_subscriber->whereDate('last_login_at', '<=', Carbon::now()->subDays(30))
                    ->with('transactions')
                    ->whereHas('transactions.package', function ( $transactions ) use( $course_id ) {
                        $transactions->where('course_id', $course_id);
                    });

            $total_subscriptions->where('course_id', $course_id);

        }

        if($test) {

            $packageIds = TestResult::where('test_id', $test)->groupBy('package_id')->pluck('package_id');

            $total_users->with(['test_results' => function ( $test_results ) use( $test ) {
                $test_results->where('test_id', $test);
            }])
                ->whereHas('test_results', function ( $test_results ) use($test) {
                    $test_results->where('test_id', $test);
                })
                ->get();

            $subscribers = $total_users;

            $dormant_subscriber->whereDate('last_login_at', '<=', Carbon::now()->subDays(30))
                ->with('test_results')
                ->whereHas('test_results', function ( $test_results ) use( $test ) {
                    $test_results->where('test_id', $test);
                });
            $total_subscriptions->whereIn('package_id', $packageIds);
            // total subscriptions
        }


        $total_users->get();
        $subscribers->get();
        $dormant_subscriber_count = $dormant_subscriber->count();

        $total_subscriptions->get();

    }
        return view('admin::pages.dashboard.index', compact('total_users','dormant_subscriber_count',
            'subscribers','total_subscriptions','tests','testCounts', 'courses','blogs','admins','exam_notifications','videos',
            'package_rating_five','package_rating_four','package_rating_three','package_rating_two','package_rating_one',
            'user_percentage_of_increment','subscription_percentage_of_increment','subscriber_percentage_of_increment',
            'dormant_user_percentage_of_increment','user_doubts', 'gender','test'));

    }


    public function create()
    {

    }

    public function graphicalView(Request $request)
    {

        // userwise course
      $courses = Course::with('packages')
                ->whereHas('packages')
                ->pluck('name');

        // userwise test
      $tests = Test::with('test_results')
            ->whereHas('test_results')
            ->pluck('name');

        // subject user doubts

      $subjects  = Subject::with('doubts')
            ->whereHas('doubts')
            ->pluck('name');

      $userSubjectDoubts = Subject::with('doubts')
            ->whereHas('doubts')
            ->get();

//      return $userSubjectDoubts;

      $userSubjectDoubtCount = [];

      foreach($userSubjectDoubts as $userSubjectDoubt){
            $userSubjectDoubtCount[] =  $userSubjectDoubt->doubts->count();
      }

      $user_courses  = Course::with('doubts')
            ->whereHas('doubts')
            ->pluck('name');

      $userCourseDoubts = Course::with('doubts')
            ->whereHas('doubts')
            ->withCount('doubts')
            ->get();


      $userCourseDoubtCount = [];

      foreach($userCourseDoubts as $userCourseDoubt){
            $userCourseDoubtCount[] =  $userCourseDoubt->doubts->count();
      }

        if($request->date_range) {

            $dateRange = $request->date_range;

            $dates = explode(' - ',$dateRange );
            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])).' 00:00:00');
            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])).' 00:00:00');

            $courseUsers = Course::with('transactions')
                            ->whereHas('transactions')
                            ->get();

            $usersCount = [];
            foreach($courseUsers as $courseUser){
                $usersCount[] =  $courseUser->transactions->whereBetween('created_at', [$start_date, $end_date])->count();
            }

            $testUsers = Test::with('test_results')
                            ->whereHas('test_results')
                            ->get();

            $testUserCount = [];
            foreach($testUsers as $testUser){
                $testUserCount[] =  $testUser->test_results->whereBetween('created_at', [$start_date, $end_date])->count();
            }

            // user suject doubts

            $userSubjectDoubtCount = [];

            foreach($userSubjectDoubts as $userSubjectDoubt){
                $userSubjectDoubtCount[] =  $userSubjectDoubt->doubts->whereBetween('created_at', [$start_date, $end_date])->count();
            }

            // course user doubts

            $userCourseDoubtCount = [];

            foreach($userCourseDoubts as $userCourseDoubt){
                $userCourseDoubtCount[] =  $userCourseDoubt->doubts->whereBetween('created_at', [$start_date, $end_date])->count();
            }

        } else {

            $courseUsers = Course::withCount('users')
                ->whereHas('packages')
                ->get();

            $usersCount = [];
            foreach($courseUsers as $courseUser){
                $usersCount[] =  $courseUser->users_count;
            }

            $testUsers = Test::withCount('users')
                ->get();

            $testUserCount = [];
            foreach($testUsers as $testUser){
                $testUserCount[] =  $testUser->users_count;
            }

        }

        if($usersCount) {
            $max_userCount = max($usersCount);
        }else {
            $max_userCount = 0;
        }

        if(!$testUserCount) {
            $max_testCount = 0;
        }else {
            $max_testCount = max($testUserCount);
        }

        if(!$userCourseDoubtCount) {
            $maxCourseDoubtCount = 0;
        }else {
            $maxCourseDoubtCount = max($userCourseDoubtCount);
        }


        if(!$userSubjectDoubtCount) {
            $maxSubjectDoubtCount = 0;
        }else {
            $maxSubjectDoubtCount = max($userSubjectDoubtCount);
        }

        return view('admin::pages.dashboard.graphical_dashboard', compact('courses','usersCount','testUserCount',
            'max_userCount','tests','max_testCount','userSubjectDoubtCount','maxCourseDoubtCount','maxSubjectDoubtCount','subjects','user_courses','subjects','userCourseDoubtCount'));
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
