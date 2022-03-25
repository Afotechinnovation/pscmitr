<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PopularSearch;
use Illuminate\Auth\Access\HandlesAuthorization;

class PopularSearchPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function viewAny(Admin $Admin)
    {
        if($Admin->can('popular_search.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Package $package
     * @return mixed
     */
    public function view(Admin $Admin, PopularSearch $popular_search)
    {
        if($Admin->can('popular_search.view'))
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
        if($Admin->can('popular_search.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Package $package
     * @return mixed
     */
    public function update(Admin $Admin,PopularSearch $popular_search)
    {
        if($Admin->can('popular_search.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Package $package
     * @return mixed
     */
    public function delete(Admin $Admin, PopularSearch $popular_search)
    {
        if($Admin->can('popular_search.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Package $package
     * @return mixed
     */
    public function restore(Admin $Admin, PopularSearch $popular_search)
    {
        //
    }

    public function forceDelete(Admin $Admin, PopularSearch $popular_search)
    {
        //
    }

}
