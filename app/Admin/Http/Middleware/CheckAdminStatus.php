<?php


namespace App\Admin\Http\Middleware;


use Illuminate\Auth\AuthenticationException;

class CheckAdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next)
    {
        if (auth()->user()->active != 1) {
            auth()->logout();
            throw new AuthenticationException(
                'Unauthenticated.', ["admin"], route("admin.login")
            );
        }

        return $next($request);
    }

}
