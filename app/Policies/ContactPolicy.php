<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewAny(Admin $admin)
    {
        if($admin->can('contacts.viewAny'))
        {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $contact
     * @return mixed
     */
    public function view(Admin $admin, Contact $contact)
    {
        if($admin->can('contacts.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        if($admin->can('contacts.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $contact
     * @return mixed
     */
    public function update(Admin $admin, Contact $contact)
    {
        if($admin->can('contacts.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $contact
     * @return mixed
     */
    public function delete(Admin $admin, Contact $contact)
    {
        if($admin->can('contacts.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $contact
     * @return mixed
     */
    public function restore(Admin $admin, Contact $contact)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Subject  $contact
     * @return mixed
     */
    public function forceDelete(Admin $admin, Contact $contact)
    {
        //
    }
}
