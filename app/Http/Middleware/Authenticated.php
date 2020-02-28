<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = substr($request->getPathInfo(), 1, 3);
        $isApiRoute = $prefix == 'api';
        $user = Auth::user();

        if($user)
        {
            /*if ($isApiRoute) {
                if($user->is_active == 0){

                    return response()->json(['success' => 0, 'error' => ['code'=>APIController::$blockedAccuont, 'msg'=>'Blocked account']]);
                }
                if($user->is_active_by_customer != 1){
                    return response()->json(['success' => 0, 'error' => ['msg'=>'inactive account', 'code'=>APIController::$inactiveAccount]]);
                }
                if($user->email_verified != 1){

                    return response()->json(['success' => 0, 'error' => ['code'=>APIController::$emailNotVerifiedCode, 'msg'=>'Email is not verified']]);
                }
            }*/
            return $next($request);
        }
        else
        {
            if ($isApiRoute) {
                return response()->json(['status' => false, 'error' => 'Token is invalid']);
            } else {
                return redirect()->route('login');
            }
        }
    }
}
