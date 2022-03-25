<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            //Admin
            [
                "name" => 'admin.viewAny',
                "display_name" => 'View all admins',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'admin.view',
                "display_name" => 'View admin',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'admin.create',
                "display_name" => 'Create admin',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'admin.update',
                "display_name" => 'Update admin',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'admin.destroy',
                "display_name" => 'Delete admin',
                "guard_name" => 'admin'
            ],

            //Banners
            [
                "name" => 'banners.viewAny',
                "display_name" => 'View all banners',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'banners.view',
                "display_name" => 'View banner',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'banners.create',
                "display_name" => 'Create banner',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'banners.update',
                "display_name" => 'Update banner',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'banners.destroy',
                "display_name" => 'Delete banner',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'banners.changeOrder',
                "display_name" => 'Change banner order',
                "guard_name" => 'admin'
            ],

            //Categories

            [
                "name" => 'categories.viewAny',
                "display_name" => 'View all categories',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'categories.view',
                "display_name" => 'View category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'categories.create',
                "display_name" => 'Create category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'categories.update',
                "display_name" => 'Update category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'categories.destroy',
                "display_name" => 'Delete category',
                "guard_name" => 'admin'
            ],

            //Blogs

            [
                "name" => 'blogs.viewAny',
                "display_name" => 'View all blogs',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogs.view',
                "display_name" => 'View blog',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogs.create',
                "display_name" => 'Create blog',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogs.update',
                "display_name" => 'Update blog',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogs.destroy',
                "display_name" => 'Delete blog',
                "guard_name" => 'admin'
            ],

            //Blog Categories

            [
                "name" => 'blogCategories.viewAny',
                "display_name" => 'View all blog category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogCategories.view',
                "display_name" => 'View blog category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogCategories.create',
                "display_name" => 'Create blog category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogCategories.update',
                "display_name" => 'Update blog category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'blogCategories.destroy',
                "display_name" => 'Delete blog category',
                "guard_name" => 'admin'
            ],

            //Exam Categories

            [
                "name" => 'examCategories.viewAny',
                "display_name" => 'View all exam category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examCategories.view',
                "display_name" => 'View exam category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examCategories.create',
                "display_name" => 'Create exam category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examCategories.update',
                "display_name" => 'Update exam category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examCategories.destroy',
                "display_name" => 'Delete exam category',
                "guard_name" => 'admin'
            ],

            //Exam Notifications

            [
                "name" => 'examNotifications.viewAny',
                "display_name" => 'View all exam notification',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examNotifications.view',
                "display_name" => 'View exam notification',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examNotifications.create',
                "display_name" => 'Create exam notification',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examNotifications.update',
                "display_name" => 'Update exam notification',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'examNotifications.destroy',
                "display_name" => 'Delete exam notification',
                "guard_name" => 'admin'
            ],


            //Testimonials

            [
                "name" => 'testimonials.viewAny',
                "display_name" => 'View all testimonials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'testimonials.view',
                "display_name" => 'View testimonials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'testimonials.create',
                "display_name" => 'Create testimonials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'testimonials.update',
                "display_name" => 'Update testimonials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'testimonials.destroy',
                "display_name" => 'Delete testimonials',
                "guard_name" => 'admin'
            ],

            //Videos

            [
                "name" => 'videos.viewAny',
                "display_name" => 'View all videos',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'videos.view',
                "display_name" => 'View video',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'videos.create',
                "display_name" => 'Create video',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'videos.destroy',
                "display_name" => 'Delete video',
                "guard_name" => 'admin'
            ],

            //Documents

            [
                "name" => 'documents.viewAny',
                "display_name" => 'View all documents',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'documents.view',
                "display_name" => 'View document',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'documents.create',
                "display_name" => 'Create document',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'documents.destroy',
                "display_name" => 'Delete document',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'documents.downloadFile',
                "display_name" => 'Download document',
                "guard_name" => 'admin'
            ],

            //Course

            [
                "name" => 'courses.viewAny',
                "display_name" => 'View all courses',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'courses.view',
                "display_name" => 'View course',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'courses.create',
                "display_name" => 'Create course',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'courses.update',
                "display_name" => 'Update course',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'courses.destroy',
                "display_name" => 'Delete course',
                "guard_name" => 'admin'
            ],

            // Sections

            [
                "name" => 'sections.viewAny',
                "display_name" => 'View all sections',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'sections.view',
                "display_name" => 'View section',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'sections.create',
                "display_name" => 'Create section',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'sections.update',
                "display_name" => 'Update course',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'sections.destroy',
                "display_name" => 'Delete section',
                "guard_name" => 'admin'
            ],

            //Packages
            [
                "name" => 'packages.viewAny',
                "display_name" => 'View all packages',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'packages.view',
                "display_name" => 'View packages',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'packages.create',
                "display_name" => 'Create package',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'packages.update',
                "display_name" => 'Update package',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'packages.destroy',
                "display_name" => 'Delete package',
                "guard_name" => 'admin'
            ],

            //Package Videos
            [
                "name" => 'package-videos.viewAny',
                "display_name" => 'View all package videos',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-videos.view',
                "display_name" => 'View package video',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-videos.create',
                "display_name" => 'Create package video',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-videos.destroy',
                "display_name" => 'Delete package video',
                "guard_name" => 'admin'
            ],

            //Package Study Materials
            [
                "name" => 'package-study-materials.viewAny',
                "display_name" => 'View all package study materials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-study-materials.view',
                "display_name" => 'View package package study materials',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-study-materials.create',
                "display_name" => 'Create package package study material',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-study-materials.destroy',
                "display_name" => 'Delete package package study material',
                "guard_name" => 'admin'
            ],

            // Package Categories
            [
                "name" => 'package-categories.viewAny',
                "display_name" => 'View all package Categories',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-categories.view',
                "display_name" => 'View package  Categories',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-categories.create',
                "display_name" => 'Create package Categories',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-categories.destroy',
                "display_name" => 'Delete package Categories',
                "guard_name" => 'admin'
            ],
            // user doubts

            [
                "name" => 'doubts.viewAny',
                "display_name" => 'View all Doubts',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'doubts.view',
                "display_name" => 'View Doubts',
                "guard_name" => 'admin'
            ],

            [
                "name" => 'doubts.update',
                "display_name" => 'Update Doubts',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'doubts.destroy',
                "display_name" => 'Delete Doubts',
                "guard_name" => 'admin'
            ],

            // Test Categories

            [
                "name" => 'test-categories.viewAny',
                "display_name" => 'View all test categories',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-categories.view',
                "display_name" => 'View test category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-categories.create',
                "display_name" => 'Create test category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-categories.update',
                "display_name" => 'Update test category',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-categories.destroy',
                "display_name" => 'Delete test category',
                "guard_name" => 'admin'
            ],

            // Tests

            [
                "name" => 'tests.viewAny',
                "display_name" => 'View all Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'tests.view',
                "display_name" => 'View Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'tests.create',
                "display_name" => 'Create Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'tests.update',
                "display_name" => 'Update Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'tests.destroy',
                "display_name" => 'Delete Tests',
                "guard_name" => 'admin'
            ],

            // Test Questions

            [
                "name" => 'test-questions.viewAny',
                "display_name" => 'View all Test Questions',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-questions.view',
                "display_name" => 'View Test Question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-questions.create',
                "display_name" => 'Create Test Question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-questions.update',
                "display_name" => 'Update Test Question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'test-questions.destroy',
                "display_name" => 'Delete Test Question',
                "guard_name" => 'admin'
            ],

            // Package Test

            [
                "name" => 'package-tests.viewAny',
                "display_name" => 'View all package Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-tests.view',
                "display_name" => 'View package  Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-tests.create',
                "display_name" => 'Create package Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-tests.update',
                "display_name" => 'Update package  Tests',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'package-tests.destroy',
                "display_name" => 'Delete package Tests',
                "guard_name" => 'admin'
            ],

            //Subject

            [
                "name" => 'subjects.viewAny',
                "display_name" => 'View all subject',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'subjects.view',
                "display_name" => 'View subject',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'subjects.create',
                "display_name" => 'Create subject',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'subjects.update',
                "display_name" => 'Update subject',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'subjects.destroy',
                "display_name" => 'Delete subject',
                "guard_name" => 'admin'
            ],


            //Questions
            [
                "name" => 'questions.viewAny',
                "display_name" => 'View all questions',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'questions.view',
                "display_name" => 'View question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'questions.create',
                "display_name" => 'Create question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'questions.update',
                "display_name" => 'Update question',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'questions.destroy',
                "display_name" => 'Delete question',
                "guard_name" => 'admin'
            ],

            //Chapter

            [
                "name" => 'chapters.viewAny',
                "display_name" => 'View all chapter',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'chapters.view',
                "display_name" => 'View chapter',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'chapters.create',
                "display_name" => 'Create chapter',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'chapters.update',
                "display_name" => 'Update chapter',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'chapters.destroy',
                "display_name" => 'Delete chapter',
                "guard_name" => 'admin'
            ],

            //Nodes

            [
                "name" => 'nodes.create',
                "display_name" => 'Create node',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'nodes.destroy',
                "display_name" => 'Delete node',
                "guard_name" => 'admin'
            ],

            // Popular Search

            [
                "name" => 'popular_search.viewAny',
                "display_name" => 'View all popular search',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'popular_search.view',
                "display_name" => 'View popular search',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'popular_search.create',
                "display_name" => 'Create popular search',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'popular_search.update',
                "display_name" => 'Update popular search',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'popular_search.destroy',
                "display_name" => 'Delete popular search',
                "guard_name" => 'admin'
            ],
            // Contact

            [
                "name" => 'contacts.viewAny',
                "display_name" => 'View all Contacts',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'contacts.view',
                "display_name" => 'View Contact',
                "guard_name" => 'admin'
            ],

            [
                "name" => 'contacts.destroy',
                "display_name" => 'Delete Contact',
                "guard_name" => 'admin'
            ],

            // Student

            [
                "name" => 'students.viewAny',
                "display_name" => 'View all Students',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'students.view',
                "display_name" => 'View Students',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'students.create',
                "display_name" => 'Create Students',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'students.update',
                "display_name" => 'Update Students',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'students.destroy',
                "display_name" => 'Delete Students',
                "guard_name" => 'admin'
            ],

            // Transaction

            [
                "name" => 'transactions.viewAny',
                "display_name" => 'View all Transactions',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'transactions.view',
                "display_name" => 'View Transactions',
                "guard_name" => 'admin'
            ],
            // roles

            [
                "name" => 'role.viewAny',
                "display_name" => 'View all roles',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'role.view',
                "display_name" => 'View roles',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'role.create',
                "display_name" => 'Create roles',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'role.update',
                "display_name" => 'Update roles',
                "guard_name" => 'admin'
            ],
            [
                "name" => 'role.destroy',
                "display_name" => 'Delete roles',
                "guard_name" => 'admin'
            ],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $permissions = collect($permissions)->pluck('name');

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $admin->syncPermissions($permissions);

        Role::create(['name' => 'content-editor', 'guard_name' => 'admin']);

        Role::create(['name' => 'test-creator', 'guard_name' => 'admin']);

    }
}
