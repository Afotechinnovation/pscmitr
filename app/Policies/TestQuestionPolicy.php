<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TestQuestion;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestQuestionPolicy
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
        if($Admin->can('test-questions.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function view(Admin $Admin, TestQuestion $testQuestion)
    {
        if($Admin->can('test-questions.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function create(Admin $Admin)
    {
        if($Admin->can('test-questions.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function update(Admin $Admin, TestQuestion $testQuestion)
    {
        if($Admin->can('test-questions.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function delete(Admin $Admin, TestQuestion $testQuestion)
    {
        if($Admin->can('test-questions.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function restore(Admin $Admin, TestQuestion $testQuestion)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\TestQuestion $testQuestion
     * @return mixed
     */
    public function forceDelete(Admin $Admin, TestQuestion $testQuestion)
    {
        //
    }

}
