<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Course;
use App\Models\ExamCategory;
use App\Models\Package;
use App\Models\PopularSearch;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\Testimonial;
use App\Models\TestResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        //Popular Classes (Courses)
        $courses = Course::with(['packages' => function ( $packages ) {
            $packages->where('is_published', true)
                    ->ofVisible()
                    ->take(6);
            }])
            ->whereHas('packages', function ( $packages ) {
                $packages->where('is_published', true)
                 ->ofVisible();
            })
            ->take(5)
            ->get();


        $test_only_courses = Course::with(['packages' => function ( $packages ) {
            $packages->where('is_published', true)
                ->withCount('package_study_materials')
                ->having('package_study_materials_count', '<', 1)
                ->withCount('package_tests')
                ->having('package_tests_count', '>', 0)
                ->withCount('package_videos')
                ->having('package_videos_count', '<', 1)
                ->ofVisible()
                ->take(6);
            }])
            ->whereHas('packages', function ( $packages ) {
                $packages->where('is_published', true)
                    ->withCount('package_study_materials')
                    ->having('package_study_materials_count', '<', 1)
                    ->withCount('package_tests')
                    ->having('package_tests_count', '>', 0)
                    ->withCount('package_videos')
                    ->having('package_videos_count', '<', 1)
                    ->ofVisible();
            })
            ->take(5)
            ->get();


        if(Auth::user()){
            $user =  User::findOrFail(Auth::id());
        }
        else {
            $user = [];
        }


        //Notifications and Applications (Exam notifications)
        $exam_notification_categories = ExamCategory::with(['exam_notifications' => function ($exam_notifications) {
                $exam_notifications->whereNotNull('file')
                    ->whereNotNull('url')
                    ->where('last_date', '>=', Carbon::today())
                    ->where('is_published', true)
                    ->take(4);
            }])
             ->with(['exam_applications' => function ($exam_applications) {
                 $exam_applications->whereNotNull('url')
                     ->where('last_date','>=', Carbon::today())
                     ->where('is_published', true)
                     ->take(4);
             }])
             ->whereHas('exam_notifications', function ( $exam_notifications ){
                 $exam_notifications->where('last_date', '>=', Carbon::today())
                     ->where('is_published', true);
             })
             ->orWhereHas('exam_applications', function ( $exam_applications ){
                 $exam_applications->where('last_date', '>=', Carbon::today())
                     ->where('is_published', true);
             })
            ->orderBy('order','asc')
            ->take(5)
            ->get();


        //Blogs
        $blog_categories = Category::with(['blogs' => function ($blogs) {
            $blogs->where('is_published', true)
                ->take(6);
            }])
            ->whereHas('blogs', function ( $blogs) {
                $blogs->where('is_published', true);
            })
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();

        //Testimonials
        $testimonials = Testimonial::all();
        // popular search
        $popular_searches = PopularSearch::where('status', 1)->get();

        $banner = Banner::where('status', 1)->first();

        return view('pages.home.index',compact('user','exam_notification_categories','courses','blog_categories','testimonials','popular_searches',
            'banner','test_only_courses'));
    }
}
