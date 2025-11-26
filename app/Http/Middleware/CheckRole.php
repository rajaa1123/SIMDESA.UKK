<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Load role relationship jika belum diload
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}