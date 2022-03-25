<?php

namespace App\Policies;

use App\Models\Node;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class NodePolicy
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
        //
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function view(Admin $Admin, Node $node)
    {
        //
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function create(Admin $Admin)
    {
        if($Admin->can('nodes.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function update(Admin $Admin, Node $node)
    {
        //
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function delete(Admin $Admin, Node $node)
    {
        //
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function restore(Admin $Admin, Node $node)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Node $node)
    {
        //
    }
}
