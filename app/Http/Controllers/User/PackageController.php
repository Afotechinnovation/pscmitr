<?php

namespace App\Http\Controllers\User;

use App\Exports\TestResultExport;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageRating;
use App\Models\PackageTest;
use App\Models\PackageVideo;
use App\Models\Student;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestResult;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $packages = Package::whereIn('id', $user->purchased_packages)->withTrashed()->get();

        return view('pages.user.packages.index', compact('user', 'packages'));

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
    public function show(Request $request, $id)
    {

        $user = Auth::user();
        $name_slug = $id;
        $Userpackage = Package::where('name_slug', $name_slug)->first();

        $package = Package::withTrashed()->findOrFail($Userpackage->id);
        $deletedPackages = Package::onlyTrashed()->pluck('id')->toArray();
        $packageVideos = PackageVideo::where('package_id', $Userpackage->id)->get();
        $packageVideoCount = count($packageVideos);
        $purchasedPackages = $user->purchased_packages;

        if(!(in_array($Userpackage->id, $user->purchased_packages))){

            return redirect()->route('user.packages.show', $Userpackage->name_slug);
        }

        if(!$request->watch){
            $purchasedPackageVideo = PackageVideo::whereIn('package_id', $purchasedPackages)
                ->first();
        }
        else{
            $purchasedPackageVideo = PackageVideo::where('video_id', $request->input('watch'))
                ->whereIn('package_id', $purchasedPackages)
                ->first();

        }

        $categoryIDs = Test::query()->where('is_published', true)
            ->whereHas('packages', function ($query) use ($Userpackage) {
                $query->where('package_id', $Userpackage->id);
            })
            ->pluck('category_id');

        $test_categories = TestCategory::query()
            ->whereIn('id', $categoryIDs)
            ->get();

        foreach ($test_categories as $test_category) {
            $tests = Test::query()
                ->whereHas('packages', function ($query) use ($Userpackage) {
                    $query->where('package_id', $Userpackage->id);
                })
                ->where('category_id', $test_category->id)
                ->where('is_published', true)
                ->get();

            $test_category->tests = $tests;
        }

        $package_ratings = PackageRating::where('package_id', $Userpackage->id)
            ->where('user_id', $user->id)
            ->get();

        $student = Student::where('user_id', $user->id)->first();

        $UserCompletedTestCount = TestResult::where('user_id', Auth::user()->id)
            ->where('package_id', $Userpackage->id)
            ->where('ended_at', '!=', null)
            ->count();

        $totalPackageTestCount = PackageTest::where('package_id', $Userpackage->id)
            ->count();

        return view('pages.user.packages.purchased_courses', compact('package','packageVideoCount',
            'purchasedPackages',  'purchasedPackageVideo','package_ratings', 'student','test_categories','deletedPackages','totalPackageTestCount','UserCompletedTestCount'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rating_destroy(Request $request)
    {
        $package_rating = PackageRating::findOrFail($request->id);

        $package_rating->delete();

        return response()->json(true, 200);
    }

    public function downloadCerticficatePdf(Request $request)
    {
        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);

        $package = Package::withTrashed()->findOrFail($request->package);

        $testResult = TestResult::where('user_id', Auth::user()->id)
            ->where('package_id', $request->package)
            ->where('ended_at', '!=', null)
            ->orderBy('id', 'DESC')
            ->first();

        return view('pages.user.packages.course_completion',compact('user','package','testResult'));

    }
}
