<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Highlight;
use App\Models\Package;
use App\Models\PackageHighlight;
use Illuminate\Http\Request;

class CourseController extends Controller
{
   public function index(Request $request){

       $courses = Course::with('packages')
           ->whereHas('packages', function ($packages){
               $packages->where('is_published', true)
                        ->ofVisible();
           })->get();

       $package_types = Highlight::all();

       $tab = $request->filled('tab') ? $request->input('tab') : 'courses';

       $page = $request->filled('page') ? $request->input('page') : '1';

       $packages = Package::getFilteredPackages(
           $request->input('courses'),
           $request->input('package_types'),
           $request->input('package_type'),
           $request->input('ratings'),
           $request->input('search'),
           $request->input( 'page'),
           $request->input('limit'),
           $request->input('is_published'),

       );

       return view('pages.courses.index', compact('courses', 'packages', 'tab','package_types', 'page'));
   }

   public function show(){
       return view('pages.courses.show');
   }

   public function purchased_courses(){
       return view('pages.courses.purchased_courses');
   }

}
