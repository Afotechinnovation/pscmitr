<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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
        if($Admin->can('documents.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Document  $document
     * @return mixed
     */
    public function view(Admin $Admin, Document $document)
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
        if($Admin->can('documents.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Document  $document
     * @return mixed
     */
    public function update(Admin $Admin, Document $document)
    {
        //
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Document  $document
     * @return mixed
     */
    public function delete(Admin $Admin, Document $document)
    {
        //
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Document  $document
     * @return mixed
     */
    public function downloadFile(Admin $Admin, Document $document)
    {
        if($Admin->can('documents.downloadFile'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Document  $document
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Document $document)
    {
        //
    }
}
