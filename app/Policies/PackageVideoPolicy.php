<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PackageVideo;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageVideoPolicy
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
        if($Admin->can('package-videos.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Package $packageVideo
     * @return mixed
     */
    public function view(Admin $Admin, PackageVideo $packageVideo)
    {
        if($Admin->can('package-videos.view'))
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
        if($Admin->can('package-videos.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageVideo $packageVideo
     * @return mixed
     */
    public function delete(Admin $Admin, PackageVideo $packageVideo)
    {
        if($Admin->can('package-videos.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageVideo $packageVideo
     * @return mixed
     */
    public function restore(Admin $Admin, PackageVideo $packageVideo)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageVideo $packageVideo
     * @return mixed
     */
    public function forceDelete(Admin $Admin, PackageVideo $packageVideo)
    {
        //
    }

}
