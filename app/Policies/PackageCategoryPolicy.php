<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PackageCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageCategoryPolicy
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
        if($Admin->can('package-categories.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageCategory $PackageCategory
     * @return mixed
     */
    public function view(Admin $Admin, PackageCategory $PackageCategory)
    {
        if($Admin->can('package-categories.view'))
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
        if($Admin->can('package-categories.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageCategory $PackageCategory
     * @return mixed
     */
    public function delete(Admin $Admin, PackageCategory $PackageCategory)
    {
        if($Admin->can('package-categories.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageCategory $PackageCategory
     */
    public function restore(Admin $Admin, PackageCategory $PackageCategory)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageCategory $PackageCategory
     * @return mixed
     */
    public function forceDelete(Admin $Admin, PackageCategory $PackageCategory)
    {
        //
    }
}
