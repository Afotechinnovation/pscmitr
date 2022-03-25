<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;


    public function viewAny(Admin $Admin)
    {
        if($Admin->can('transactions.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $transaction
     * @return mixed
     */
    public function view(Admin $Admin, Transaction $transaction)
    {
        if($Admin->can('transactions.view'))
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
        if($Admin->can('transactions.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $transaction
     * @return mixed
     */
    public function update(Admin $Admin, Transaction $transaction)
    {
        if($Admin->can('transactions.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $transaction
     * @return mixed
     */
    public function delete(Admin $Admin, Transaction $transaction)
    {
        if($Admin->can('transactions.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $transaction
     * @return mixed
     */
    public function restore(Admin $Admin, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $transaction
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Transaction $transaction)
    {
        //
    }
}
