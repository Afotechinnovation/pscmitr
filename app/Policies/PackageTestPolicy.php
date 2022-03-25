<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PackageTest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageTestPolicy
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
        if($Admin->can('package-tests.viewAny'))
        {
            return true;
        }
        return false;

    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $package_test
     * @return mixed
     */
    public function view(Admin $Admin, PackageTest $package_test)
    {
        if($Admin->can('package-tests.view'))
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
        if($Admin->can('package-tests.create'))
        {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test  $package_test
     * @return mixed
     */
    public function update(Admin $Admin, PackageTest $package_test)
    {
        if($Admin->can('package-tests.update'))
        {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function delete(Admin $Admin, PackageTest $package_test)
    {
        if($Admin->can('package-tests.destroy'))
        {
            return true;
       }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $package_test
     */
    public function restore(Admin $Admin, PackageTest $package_test)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $package_test
     * @return mixed
     */
    public function forceDelete(Admin $Admin, PackageTest $package_test)
    {
        //
    }
}
