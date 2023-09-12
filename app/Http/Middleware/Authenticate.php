<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Check if the user is not authenticated
        if (! $request->expectsJson()) {
            // Check if the token exists in the request query parameter
            $token = $request->query('token');

            // Assuming the token is sent as a query parameter from application x
            // You can also retrieve the token from headers or other request data
            if ($token) {

                // dd($token);
                // Find the user by token
                $user = User::where('idnik', $token)->first();
                // If user is found, log in the user and redirect to the intended URL
                if ($user) {
                    Auth::login($user);
                    $userWithJoin = User::join('user', 'user.idnik', '=', 'login.idnik')
    ->leftJoin('access_menu', 'access_menu.idnik', '=', 'user.idnik')
    ->where('user.idnik', $user->idnik)
    ->select('user.*', 'login.*', 'access_menu.access_type')
    ->first();

            // dd($userWithJoin);
            $request->session()->put('user', $userWithJoin);
            return route('root');;
                }
            }

            // If the token is not valid or does not exist, redirect to the login page
            return route('login');
        }
    }
}
