<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userInput = $request->all();
        $allowed = '<a><code><i><strong>';
        array_walk_recursive($userInput, $allowed, function (&$userInput, $allowed) {
            $userInput = strip_tags($userInput, $allowed);
        });
        $request->merge($userInput);
        return $next($request);
    }
}
