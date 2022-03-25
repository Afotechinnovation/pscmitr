<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Course;
use App\Models\Highlight;
use App\Models\PackageHighlight;
use App\Models\State;
use App\Models\Student;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TestWinner;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.app', function($view)
        {
            $nav_bar_courses = Course::with(['package_highlights' => function ( $package_highlights ) {
                     $package_highlights->take(5);
                }])
                ->whereHas('package_highlights.highlight')
                ->whereHas('packages')
                ->take(2)
                ->get();

//            $highlightCourses = $nav_bar_courses->pluck('id')->toArray();
//
//            // package highlights
//
//            $package_highlights = PackageHighlight::whereIn('course_id', $highlightCourses)
////                ->groupBy('course_id')
////                ->orderBy('highlight_id')
//                ->pluck('highlight_id')->toArray();
//
//            $package_types = [];
//
//            $package_types = Highlight::whereIn('id', $package_highlights)->get();
//
//            info($package_types);

            $package_highlights = Highlight::all();
            if(Auth::user()) {

                $student = Student::with('user')
                    ->whereHas('user', function ($user) {
                        $user->where('id', Auth::user()->id);
                    })
                    ->first();



                $view->with(['nav_bar_courses' => $nav_bar_courses,
                    'student' => $student,
                    'package_highlights' => $package_highlights
                ]);
            }
            else{
                $view->with(['nav_bar_courses' => $nav_bar_courses, 'package_highlights' => $package_highlights]);
            }

        });

        View::composer('layouts.includes.footer', function($view)
        {
            $footer_courses = Course::with('packages')
                ->whereHas('packages')
                ->get();

            $view->with('footer_courses', $footer_courses);

        });
        View::composer('layouts.includes.header', function($view)
        {

            if(Auth::user())
            {
                $student = Student::with('user')
                    ->whereHas('user', function ($user){
                        $user->where('id', Auth::user()->id);
                    })
                    ->first();

                $subscribers = Transaction::groupBy('user_id')
                    ->pluck('user_id')->toArray();

                $view->with(['student', $student, 'subscribers' => $subscribers ]);

            }

        });
        View::composer('layouts.includes.modals', function($view)
        {
            $test_winner = TestWinner::orderBy('id','DESC')
                    ->first();


            if(Auth::user()) {

                $student = Student::with('user')
                    ->whereHas('user', function ($user){
                        $user->where('id', Auth::user()->id);
                    })
                    ->first();

                $view->with(['student' => $student, 'test_winner' => $test_winner]);

            }
            $defaultCountry = Country::where('name', 'like', 'India')->first();
            $defaultState = State::where('country_id', $defaultCountry->id)->where('name', 'like', 'Kerala')->first();
            $view->with(['defaultCountry'=> $defaultCountry, 'defaultState' => $defaultState, 'test_winner' => $test_winner]);

        });
    }
}
