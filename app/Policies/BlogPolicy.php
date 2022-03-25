<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function viewAny(Admin $Admin)
    {
        if($Admin->can('blogs.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Blog  $blog
     * @return mixed
     */
    public function view(Admin $Admin, Blog $blog)
    {
        if($Admin->can('blogs.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function create(Admin $Admin)
    {
        if($Admin->can('blogs.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Blog  $blog
     * @return mixed
     */
    public function update(Admin $Admin, Blog $blog)
    {
        if($Admin->can('blogs.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Blog  $blog
     * @return mixed
     */
    public function delete(Admin $Admin, Blog $blog)
    {
        if($Admin->can('blogs.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Blog  $blog
     * @return mixed
     */
    public function restore(Admin $Admin, Blog $blog)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Blog  $blog
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Blog $blog)
    {
        //
    }
}
