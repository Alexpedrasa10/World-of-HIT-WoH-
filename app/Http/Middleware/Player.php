<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Player
{

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->first();

        return !empty($user) ? $next($request) :  response()->json(['message' => 'Wrong api token'], 404);;
    }
}
