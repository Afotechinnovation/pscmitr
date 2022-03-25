<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Section;

use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $Admin)
    {
        if($Admin->can('sections.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function view(Admin $Admin, Section $section)
    {
        if($Admin->can('sections.view'))
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
        if($Admin->can('sections.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function update(Admin $Admin, Section $section)
    {
        if($Admin->can('categories.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function delete(Admin $Admin, Section $section)
    {
        if($Admin->can('sections.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function restore(Admin $Admin, Section $section)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Section $section)
    {
        //
    }
}
