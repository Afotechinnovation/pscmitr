<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
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
        if($Admin->can('tests.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function view(Admin $Admin, Test $test)
    {
        if($Admin->can('tests.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function create(Admin $Admin)
    {
        if($Admin->can('tests.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function update(Admin $Admin, Test $test)
    {
        if($Admin->can('tests.update'))
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
    public function delete(Admin $Admin, Test $test)
    {
        if($Admin->can('tests.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function restore(Admin $Admin, Test $test)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Test $test
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Test $test)
    {
        //
    }

}
