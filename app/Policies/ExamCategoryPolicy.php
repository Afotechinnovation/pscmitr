<?php

namespace App\Policies;

use App\Models\ExamCategory;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamCategoryPolicy
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
        if($Admin->can('examCategories.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamCategory  $examCategory
     * @return mixed
     */
    public function view(Admin $Admin, ExamCategory $examCategory)
    {
        if($Admin->can('examCategories.view'))
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
        if($Admin->can('examCategories.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamCategory  $examCategory
     * @return mixed
     */
    public function update(Admin $Admin, ExamCategory $examCategory)
    {
        if($Admin->can('examCategories.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamCategory  $examCategory
     * @return mixed
     */
    public function delete(Admin $Admin, ExamCategory $examCategory)
    {
        if($Admin->can('examCategories.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamCategory  $examCategory
     * @return mixed
     */
    public function restore(Admin $Admin, ExamCategory $examCategory)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamCategory  $examCategory
     * @return mixed
     */
    public function forceDelete(Admin $Admin, ExamCategory $examCategory)
    {
        //
    }
}
