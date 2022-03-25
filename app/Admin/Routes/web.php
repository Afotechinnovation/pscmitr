<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

namespace App\Admin\Http\Controllers;
use App\Admin\Http\Middleware\CheckAdminStatus;
use App\Admin\Services\VimeoVideoService;
use App\Models\PackageStudyMaterial;
use App\Models\PopularSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (\auth()->guard('admin')->check()) {
        return redirect()->route('admin.home');
    }

    return redirect()->route('admin.login');
})->name('root');

Route::namespace('App\Admin\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::middleware(['auth:admin', CheckAdminStatus::class])->group(function () {
    Route::get('/home', [ HomeController::class, 'index' ] )->name('home');
    Route::get('/dashboard', [ DashboardController::class, 'index' ] )->name('dashboard');
    Route::get('/dashboard/graphical_view', [ DashboardController::class, 'graphicalView' ] )->name('dashboard.graphical_view');

    Route::get('change-exam_category-order', [ ExamCategoryController::class, 'changeOrder' ] )->name('exam-category.change-order');
    Route::resource('admins', AdminController::class);
    Route::post('role/check_email_unique',[ AdminController::class,'check_email_unique' ])->name('admin.check_email_unique');

    Route::resource('banners', BannerController::class);
    Route::get('change-banners-order', [ BannerController::class, 'changeOrder' ] )->name('banners.change-order');

    Route::resource('courses', CourseController::class)->except('show');
    Route::resource('subjects', SubjectController::class);
    Route::resource('chapters', ChapterController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('blogs', BlogController::class);
    Route::post('blogs/images/store', [ BlogController::class, 'imageStore' ] )->name('blogs.images.store');
    Route::post('blogs.publish/{id}', [ BlogController::class, 'publish' ] )->name('blogs.publish');
    Route::resource('exam-categories', ExamCategoryController::class);
    Route::resource('exam-notifications', ExamNotificationController::class);
    Route::post('exam-notifications.publish/{id}', [ ExamNotificationController::class, 'publish' ])->name('exam-notifications.publish');
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('videos', VideoController::class);
    Route::post('/vimeo/videos', [ VideoController::class, 'VimeoFileStore' ])->name('vimeo.videos');
    Route::resource('nodes', NodeController::class);
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{id}/download', [ DocumentController::class, 'downloadFile' ] )->name('documents.download');
    Route::resource('doubts', UserDoubtController::class);

    Route::resource('test-results',TestResultController::class)->except('show');
    Route::get('test-results/download',[TestResultController::class, 'downloadPdf'])->name('results.download');

    Route::resource('packages', PackageController::class);
    Route::post('packages.publish/{id}', [ PackageController::class, 'publish' ] )->name('packages.publish');
  //  Route::post('package_videos/update/{id}', [ PackageVideoController::class, 'update' ] )->name('package_videos.update');
    Route::resource('packages.videos', PackageVideoController::class)->only('index','store','destroy','edit','update');
    Route::resource('packages.category', PackageCategoryController::class)->only('index','store','destroy');
    Route::resource('packages.study-materials', PackageStudyMaterialController::class)->only('index','store','destroy');
    Route::resource('packages.tests', PackageTestController::class);

//    Route::resource('live-tests', LiveTestController::class );
    Route::post('packages-tests/{id}', [ PackageTestController::class, 'update' ] )->name('package-tests.update');
    Route::get('package-tests-change-order', [ PackageTestController::class, 'changeOrder' ] )->name('packages.tests.change-order');

    Route::resource('questions', QuestionController::class);
    Route::post('questions/explanations/image_upload', [QuestionController::class, 'upload'])->name('ckeditor.upload');
    Route::post('questions/images/store', [ QuestionController::class, 'imageStore' ] )->name('questions.images.store');
    Route::get('question/download',[ QuestionController::class, 'exportToExcel' ])->name('questions.download');

    Route::resource('test-categories', TestCategoryController::class);
    Route::resource('tests', TestController::class);
    Route::post('tests.publish/{id}', [ TestController::class, 'publish' ] )->name('tests.publish');
    Route::post('tests/today-test/{id}', [ TestController::class, 'todayTest' ] )->name('tests.today-test');
    Route::post('tests/live-test/{id}', [ TestController::class, 'liveTest' ] )->name('tests.live-test');
    Route::post('tests/show/options', [ TestController::class, 'showOptions' ] )->name('tests.show-options');
    Route::resource('tests.questions', TestQuestionController::class)->except('destroy');
    Route::post('test-questions/{id}', [ TestQuestionController::class, 'update' ] )->name('test-questions.update');
    Route::get('test-questions-change-order', [ TestQuestionController::class, 'changeOrder' ] )->name('tests.questions.change-order');
    Route::resource('test-attempts', TestAttemptController::class);
    Route::resource('tests.sections', TestSectionController::class);
    Route::post('test_question/destroy/{id}', [ TestQuestionController::class, 'testQuestiondestroy' ] )->name('test_questions.destroy');
    Route::resource('sections', SectionController::class);

    Route::resource('students', StudentController::class);
    Route::resource('students.transactions', StudentTransactionController::class)->only('index','destroy');
    Route::get('student/tests/{id}',[StudentTestResultController::class, 'index'])->name('student.tests');
    Route::get('students/{student_id}/tests/{test_id}', [StudentTestAttemptController::class, 'index'])->name('student.test-attempts');


    Route::resource('roles', RoleController::class);
    Route::resource('popular-searches', PopularSearchController::class);
    Route::post('change-popular-searches-status/{popular_search}', [ PopularSearchController::class, 'changeStatus' ])->name('popular-searches.change-status');
    Route::resource('contacts', ContactController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('user-segments', UserSegmentController::class);
    Route::get('user-segment-results/{id}/download',[UserSegmentController::class, 'Pdfdownload'])->name('segment.download');
    Route::resource('test_winners', TestWinnerController::class)->only('store');

});


