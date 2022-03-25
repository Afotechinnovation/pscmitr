<?php

namespace App\Providers;

use App\Admin\Http\Controllers\SectionController;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Document;
use App\Models\ExamCategory;
use App\Models\ExamNotification;
use App\Models\Node;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageStudyMaterial;
use App\Models\PackageVideo;
use App\Models\PopularSearch;
use App\Models\Role;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\Testimonial;
use App\Models\Video;
use App\Policies\AdminPolicy;
use App\Policies\BannerPolicy;
use App\Policies\BlogCategoryPolicy;
use App\Policies\BlogPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ChapterPolicy;
use App\Policies\ContactPolicy;
use App\Policies\CoursePolicy;
use App\Policies\DocumentPolicy;
use App\Policies\ExamCategoryPolicy;
use App\Policies\ExamNotificationPolicy;
use App\Policies\NodePolicy;
use App\Policies\PackageCategoryPolicy;
use App\Policies\PackagePolicy;
use App\Policies\PackageStudyMaterialPolicy;
use App\Policies\PackageTestPolicy;
use App\Policies\PackageVideoPolicy;
use App\Policies\PopularSearchPolicy;
use App\Policies\RolePolicy;
use App\Policies\SectionPolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TestCategoryPolicy;
use App\Policies\TestimonialPolicy;
use App\Policies\TestPolicy;
use App\Policies\VideoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Admin::class => AdminPolicy::class,
         Category::class => CategoryPolicy::class,
         Blog::class => BlogPolicy::class,
         BlogCategory::class => BlogCategoryPolicy::class,
         ExamCategory::class => ExamCategoryPolicy::class,
         ExamNotification::class => ExamNotificationPolicy::class,
         Testimonial::class => TestimonialPolicy::class,
         Video::class => VideoPolicy::class,
         Node::class => NodePolicy::class,
         Document::class => DocumentPolicy::class,
         Course::class => CoursePolicy::class,
         Subject::class => SubjectPolicy::class,
         Chapter::class => ChapterPolicy::class,
         Banner::class => BannerPolicy::class,
         Package::class => PackagePolicy::class,
         PackageVideo::class => PackageVideoPolicy::class,
         PackageStudyMaterial::class => PackageStudyMaterialPolicy::class,
         PopularSearch::class => PopularSearchPolicy::class,
         Contact::class => ContactPolicy::class,
         PackageCategory::class => PackageCategoryPolicy::class,
         Test::class => TestPolicy::class,
         TestCategory::class => TestCategoryPolicy::class,
         Student::class => StudentPolicy::class,
         Section::class => SectionPolicy::class,
         Role::class => RolePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
