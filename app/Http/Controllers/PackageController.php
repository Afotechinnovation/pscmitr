<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Package;
use App\Models\PackageRating;
use App\Models\PackageTest;
use App\Models\PackageVideo;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

    public function index() {

        $courses = Course::with(['packages' => function ( $packages ) {
            $packages->where('is_published', true)
                ->ofVisible();

        }])
            ->whereHas('packages', function ( $packages ) {
                $packages->where('is_published', true)
                    ->ofVisible();
            })
            ->get();

        return view('pages.packages.index', compact('courses'));

    }
   public function show(Request $request, $id){

       if(Auth::user()){
           $user =  User::findOrFail(Auth::id());
       }
       else {
           $user = [];
       }

        $name_slug = $id;

       $package = Package::ofVisible()->where('is_published', true)
       ->where('name_slug', $name_slug)->first();
//       return $name_slug;

       $categoryIDs = Test::query()
           ->whereHas('packages', function ($query) use ($package) {
               $query->where('package_id', $package->id);
           })
           ->where('is_published', true)
           ->pluck('category_id');

       $test_categories = TestCategory::query()
           ->whereIn('id', $categoryIDs)
           ->get();

       foreach ($test_categories as $test_category) {
           $tests = PackageTest::with('test', 'package')
               ->whereHas('package', function ( $query ) use ( $package ) {
                    $query->where('package_id', $package->id);
               })
               ->whereHas('test', function ( $query ) use ( $test_category ){
                   $query->where('category_id', $test_category->id)
                       ->where('is_published', true);
               })
               ->get();

           $test_category->tests = $tests;
       }

       if($user){
           $rating_count =  PackageRating::where('package_id', $package->id)
               ->where('user_id', $user->id)
               ->count();
          // $purchasedPackages = $user->purchased_packages;
       }
       else{

           $rating_count = 0;
          // $purchasedPackages = 0;
       }

       return view('pages.packages.show', compact('package','test_categories','rating_count', 'user'));
   }

   public function purchased_courses(){

       return view('pages.packages.purchased_courses');
   }

   public function ratings(Request $request){

       if(!Auth::user()){
           return redirect()->back()->with('error', 'Oops! Please login to submit your rating');
       }

       $request->validate([
           'package_id' => 'required',
           'rating' => 'required|max:5',
           'comments' => 'nullable',
       ]);

       $package_rating = new PackageRating();
       $package_rating->package_id = $request->package_id;
       $package_rating->user_id = Auth::id();
       $package_rating->rating = $request->rating;
       $package_rating->comment = $request->comments;
       $package_rating->save();

       return redirect()->back()->with('success', 'Thank you! Your comment has been successfully submitted');

   }

    public function deleteRating(Request $request)
    {

        $package_rating = PackageRating::findOrFail($request->id);

        $package_rating->delete();

        return response()->json(true, 200);
    }

}
