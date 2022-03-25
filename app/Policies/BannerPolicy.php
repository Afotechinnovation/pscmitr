<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
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
        if($Admin->can('banners.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Banner $banner
     * @return mixed
     */
    public function view(Admin $Admin, Banner $banner)
    {
        if($Admin->can('banners.view'))
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
        if($Admin->can('banners.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Banner $banner
     * @return mixed
     */
    public function update(Admin $Admin, Banner $banner)
    {
        if($Admin->can('banners.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Banner $banner
     * @return mixed
     */
    public function delete(Admin $Admin, Banner $banner)
    {
        if($Admin->can('banners.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Banner $banner
     * @return mixed
     */
    public function restore(Admin $Admin, Banner $banner)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Banner $banner
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Banner $banner)
    {
        //
    }

    public function changeOrder(User $user)
    {
        if($user->can('banners.changeOrder'))
        {
            return true;
        }
        return false;
    }
}
