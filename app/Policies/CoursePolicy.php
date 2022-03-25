<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('courses.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Course  $course
     * @return mixed
     */
    public function view(Admin $admin, Course $course)
    {
        if($admin->can('courses.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        if($admin->can('courses.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Course  $course
     * @return mixed
     */
    public function update(Admin $admin, Course $course)
    {
        if($admin->can('courses.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Course  $course
     * @return mixed
     */
    public function delete(Admin $admin, Course $course)
    {
        if($admin->can('courses.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Course  $course
     * @return mixed
     */
    public function restore(Admin $admin, Course $course)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Course  $course
     * @return mixed
     */
    public function forceDelete(Admin $admin, Course $course)
    {
        //
    }
}
