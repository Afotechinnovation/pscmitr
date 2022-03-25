<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TestCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestCategoryPolicy
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
        if($Admin->can('test-categories.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestCategory $testCategory
     * @return mixed
     */
    public function view(Admin $Admin, TestCategory $testCategory)
    {
        if($Admin->can('test-categories.view'))
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
        if($Admin->can('test-categories.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestCategory $testCategory
     * @return mixed
     */
    public function update(Admin $Admin, TestCategory $testCategory)
    {
        if($Admin->can('test-categories.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestCategory $testCategory
     * @return mixed
     */
    public function delete(Admin $Admin, TestCategory $testCategory)
    {
        if($Admin->can('test-categories.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestCategory $testCategory
     * @return mixed
     */
    public function restore(Admin $Admin, TestCategory $testCategory)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestCategory $testCategory
     * @return mixed
     */
    public function forceDelete(Admin $Admin, TestCategory $testCategory)
    {
        //
    }
}
