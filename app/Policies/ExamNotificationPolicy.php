<?php

namespace App\Policies;

use App\Models\ExamNotification;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamNotificationPolicy
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
        if($Admin->can('examNotifications.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamNotification  $examNotification
     * @return mixed
     */
    public function view(Admin $Admin, ExamNotification $examNotification)
    {
        if($Admin->can('examNotifications.view'))
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
        if($Admin->can('examNotifications.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamNotification  $examNotification
     * @return mixed
     */
    public function update(Admin $Admin, ExamNotification $examNotification)
    {
        if($Admin->can('examNotifications.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamNotification  $examNotification
     * @return mixed
     */
    public function delete(Admin $Admin, ExamNotification $examNotification)
    {
        if($Admin->can('examNotifications.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamNotification  $examNotification
     * @return mixed
     */
    public function restore(Admin $Admin, ExamNotification $examNotification)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\ExamNotification  $examNotification
     * @return mixed
     */
    public function forceDelete(Admin $Admin, ExamNotification $examNotification)
    {
        //
    }
}
