<?php

namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class UsersMiddleware
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        info($this->auth->user()->role);

        if ($this->auth->guest() || (!$this->auth->guest() && $this->auth->user()->role== User::ROLE_STUDENT)) {

            if ($this->auth->check() && $this->auth->user()->role== User::ROLE_STUDENT) {
                return $next($request);

            } else
            {
                return redirect('/');
            }
        }
    }
}

