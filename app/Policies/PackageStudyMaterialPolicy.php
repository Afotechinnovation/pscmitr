<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PackageStudyMaterial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageStudyMaterialPolicy
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
        if($Admin->can('package-study-materials.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageStudyMaterial $packageStudyMaterial
     * @return mixed
     */
    public function view(Admin $Admin, PackageStudyMaterial $packageStudyMaterial)
    {
        if($Admin->can('package-study-materials.view'))
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
        if($Admin->can('package-study-materials.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageStudyMaterial $packageStudyMaterial
     * @return mixed
     */
    public function delete(Admin $Admin, PackageStudyMaterial $packageStudyMaterial)
    {
        if($Admin->can('package-study-materials.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageStudyMaterial $packageStudyMaterial
     */
    public function restore(Admin $Admin, PackageStudyMaterial $packageStudyMaterial)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\PackageStudyMaterial $packageStudyMaterial
     * @return mixed
     */
    public function forceDelete(Admin $Admin, PackageStudyMaterial $packageStudyMaterial)
    {
        //
    }

}
