<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
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
        if($Admin->can('testimonials.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $testimonial
     * @return mixed
     */
    public function view(Admin $Admin, Testimonial $testimonial)
    {
        if($Admin->can('testimonials.view'))
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
        if($Admin->can('testimonials.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $testimonial
     * @return mixed
     */
    public function update(Admin $Admin, Testimonial $testimonial)
    {
        if($Admin->can('testimonials.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $testimonial
     * @return mixed
     */
    public function delete(Admin $Admin, Testimonial $testimonial)
    {
        if($Admin->can('testimonials.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $testimonial
     * @return mixed
     */
    public function restore(Admin $Admin, Testimonial $testimonial)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Testimonial  $testimonial
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Testimonial $testimonial)
    {
        //
    }
}
