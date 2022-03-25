<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
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
        if($admin->can('chapters.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function view(Admin $admin, Chapter $chapter)
    {
        if($admin->can('chapters.view'))
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
        if($admin->can('chapters.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function update(Admin $admin, Chapter $chapter)
    {
        if($admin->can('chapters.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function delete(Admin $admin, Chapter $chapter)
    {
        if($admin->can('chapters.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function restore(Admin $admin, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function forceDelete(Admin $admin, Chapter $chapter)
    {
        //
    }
}
