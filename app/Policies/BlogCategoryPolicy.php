<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
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
        if($Admin->can('blogCategories.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function view(Admin $Admin, BlogCategory $blogCategory)
    {
        if($Admin->can('blogCategories.view'))
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
        if($Admin->can('blogCategories.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function update(Admin $Admin, BlogCategory $blogCategory)
    {
        if($Admin->can('blogCategories.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function delete(Admin $Admin, BlogCategory $blogCategory)
    {
        if($Admin->can('blogCategories.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function restore(Admin $Admin, BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function forceDelete(Admin $Admin, BlogCategory $blogCategory)
    {
        //
    }
}
