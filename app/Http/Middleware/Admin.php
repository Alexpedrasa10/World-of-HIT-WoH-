<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
{

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->first();

        return !empty($user) && $user->id == 1 ?  
            $next($request) : 
            response()->json(['message' => 'Only admin can do this'], 404);;
    }
}
