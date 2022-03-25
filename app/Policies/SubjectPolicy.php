<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
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
        if($admin->can('subjects.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $subject
     * @return mixed
     */
    public function view(Admin $admin, Subject $subject)
    {
        if($admin->can('subjects.view'))
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
        if($admin->can('subjects.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $subject
     * @return mixed
     */
    public function update(Admin $admin, Subject $subject)
    {
        if($admin->can('subjects.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $subject
     * @return mixed
     */
    public function delete(Admin $admin, Subject $subject)
    {
        if($admin->can('subjects.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $subject
     * @return mixed
     */
    public function restore(Admin $admin, Subject $subject)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $subject
     * @return mixed
     */
    public function forceDelete(Admin $admin, Subject $subject)
    {
        //
    }
}
