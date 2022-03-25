<?php

namespace App\Http\Controllers;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\QuestionController;
use App\Http\Controllers\User\TestAnswerController;
use App\Http\Controllers\User\TestRatingController;
use App\Http\Controllers\User\TestResultController;
use App\Http\Controllers\User\UserFavaouriteQuestionController;
use App\Http\Controllers\User\UserFavouriteTestController;
use Illuminate\Support\Facades\Route;

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



Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('courses',[CourseController::class,'index'])->name('courses.index');

Route::resource('blogs',BlogController::class);
Route::post('blogs.ratings',[BlogController::class,'blogRatings'])->name('blogs.ratings');

Route::get('packages/{id}',[PackageController::class,'show'])->name('packages.show');
Route::get('purchases-courses',[PackageController::class,'purchased_courses']);
Route::post('packages.ratings',[PackageController::class,'ratings'])->name('packages.ratings');
Route::post('delete-package-rating',[PackageController::class,'rating_destroy'])->name('packages.ratings.destroy');
Route::get('packages',[PackageController::class,'index'])->name('packages.index');

Route::resource('contact',ContactController::class);
Route::get('checkout',[PurchaseController::class,'checkout'])->name('checkout');

Route::get('exam-notifications',[ExamNotificationController::class,'index'])->name('exam-notifications');
Route::get('exam-notifications/show/{id}',[ExamNotificationController::class,'show'])->name('exam-notifications.show');

Route::post('forget_pin/otp/send',[LoginController::class,'forgot_pin_otp_send'])->name('otp.forgot_pin_otp_send');
Route::post('forget_pin/otp/verify',[LoginController::class,'forget_pin_otp_verify'])->name('forget_pin_otp.verify');
Route::post('otp-number/send',[LoginController::class,'send'])->name('otp-number.send');
Route::post('otp-number/verify',[LoginController::class,'verify'])->name('otp.verify');
Route::post('login/pin',[LoginController::class,'loginWithPin'])->name('login.pin');
Route::post('login/forgot_pin',[LoginController::class,'forgot_pin_number'])->name('login.forgot_pin');
Route::post('register',[RegisterController::class,'register'])->name('register');
Route::post('register/check_email_unique',[ RegisterController::class,'check_email_unique' ])->name('check_email_unique');
Route::post('otp/create/pin',[LoginController::class,'create_pin_number'])->name('create.pin_number');
//Route::get('login/{provider}', [AuthController::class,'redirect']);
//Route::get('login/{provider}/callback',[AuthController::class,'callBack']);
Route::get('logout',[AuthController::class,'logout']);
Route::get('auth/google', [AuthController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [AuthController::class,'handleGoogleCallback']);
Route::get('login/facebook', [AuthController::class,'redirectToFacebook']);
Route::get('login/facebook/callback', [AuthController::class,'handleFacebookCallback']);

Route::resource('sign-up',SignUpController::class);
Route::post('otp/send',[SignUpController::class,'send'])->name('otp.send');
Route::post('otp/verify',[SignUpController::class,'verify'])->name('otp.verify');
Route::post('pin-number/store',[SignUpController::class,'storePinNumber']);
Route::post('name-and-email/update',[SignUpController::class,'updateNameAndEmail']);
Route::post('user-interests/update',[SignUpController::class,'addUserInterest']);
Route::post('dob-and-gender/update',[SignUpController::class,'updateDOBAndGender']);
Route::post('state-and-country/update',[SignUpController::class,'updateStateAndCountry']);
Route::post('occupations/update',[SignUpController::class,'addOccupations']);
Route::get('test/live-tests', [TestController::class, 'liveTest'])->name('live-test');
Route::get('test/today-tests', [TestController::class, 'today_test'])->name('today_test');
Route::get('test/quick-test', [TestController::class, 'quickTest'])->name('quick-test');


// footer links
Route::get('faq',[ FAQController::class, 'index'])->name('faq');
Route::get('privacy-policy',[ PrivacyPolicyController::class, 'index'])->name('privacy-policy');
Route::get('terms-of-use',[ TermsOfUseController::class, 'index'])->name('terms-of-use');

Route::group(['middleware' => 'users'], function() {

    Route::resource('orders',OrderController::class);
    Route::resource('transactions',TransactionController::class);

    Route::prefix('user')
        ->namespace('App\Http\Controllers\User')
        ->name('user.')
        ->group(function () {
            Route::resource('packages', 'PackageController');
            Route::post('delete-package-ratings',[PackageController::class,'deleteRating'])->name('packages.ratings.destroy');
            Route::get('package/course/completion',[\App\Http\Controllers\User\PackageController::class,'downloadCerticficatePdf'])->name('package.certificate_download');
            Route::resource('dashboard', 'DashboardController');
            Route::resource('profile', 'ProfileController');
            Route::resource('purchase-history', 'PurchaseHistoryController');
            Route::post('profile/image/upload',[ProfileController::class,'ProfileUpdate'])->name('profile.image.upload');
            // Tests
            Route::resource('tests', 'TestController')->only(['index', 'show']);
            Route::post('tests/answers',  [TestAnswerController::class,'store'])->name('tests.answers.store');
            Route::post('test-question/mark-for-review', [TestAnswerController::class,'markForReview'])->name('tests.question.mark-for-review');
            Route::post('test-question/clear-response', [TestAnswerController::class,'clearResponse'])->name('tests.question.clear-response');
            Route::resource('user-favourite-questions', 'UserFavaouriteQuestionController');
            Route::post('user-favourite-questions/destroy/{id}', [UserFavaouriteQuestionController::class, 'destroy'])->name('favourite-questions.destroy');
            Route::resource('user-favourite-tests', 'UserFavouriteTestController');
            Route::post('user-favourite-tests/destroy', [UserFavouriteTestController::class, 'destroy'])->name('favourite-tests.destroy');
            Route::post('tests/submit', [TestResultController::class,'submitTest'])->name('tests.submit');
            Route::get('tests/{id}/confirmation', [TestResultController::class,'confirmation'])->name('tests.confirmation');
            Route::post('tests/solution/save-next', [TestResultController::class,'solutionSaveNext'])->name('tests.save-next');

            Route::get('tests/{id}/package/{packageId}/solution', [TestResultController::class,'solution'])->name('test-solution');
            Route::post('tests/{id}/rating', [TestRatingController::class,'store']);
            Route::resource('tests.result', 'TestResultController');
            Route::get('tests/graphical/result_analysis',[TestResultController::class,'graphical_analysis'])->name('test.graphical_analysis');
            Route::get('tests/{id}/test_result/{testresultId}/test-result-graphs', [TestResultController::class,'testResultGraphs'])->name('test-result-graphs');
            Route::resource('doubts', 'StudentDoubtsController');

            // test without pacakge
            Route::get('tests/{id}/test_result/{testresultId}/attempts', [TestResultController::class,'attempts'])->name('tests.attempts');
            Route::get('tests/{id}/test_result/{testresultId}/solution', [TestResultController::class,'solution'])->name('test-solution');
            Route::get('tests/{id}/test_result/{testresultId}/result', [TestResultController::class,'index']);
            Route::get('tests/{id}/test_result/{testresultId}/rating', [TestRatingController::class,'index']);
            Route::post('test/details/{testId}', [\App\Http\Controllers\User\TestController::class, 'testDetails'])->name('test-details');

            Route::resource('questions', 'QuestionController');
            Route::get('questions/search', [QuestionController::class,'QuestionSearch'])->name('question-search');
            Route::post('questions/fetch', [QuestionController::class,'fetch'])->name('autocomplete.fetch');
        });
});

Route::prefix('api')
    ->namespace('App\Admin\Http\Controllers\API')
    ->name('api.')
    ->group(function () {
        Route::resource('courses', 'CourseController')->only('index');
        Route::resource('subjects', 'SubjectController')->only('index');
        Route::resource('categories', 'CategoryController')->only('index');
        Route::resource('blogs', 'BlogController')->only('index');
        Route::resource('exam-categories', 'ExamCategoryController')->only('index');
        Route::resource('countries', 'CountryController')->only('index');
        Route::resource('states', 'StateController')->only('index');
    });
