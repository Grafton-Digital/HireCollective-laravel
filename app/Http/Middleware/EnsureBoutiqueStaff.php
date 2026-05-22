<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBoutiqueStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isBoutiqueStaff() || $user->boutique_id === null) {
            abort(403, 'You do not have access to the boutique dashboard.');
        }

        return $next($request);
    }
}
