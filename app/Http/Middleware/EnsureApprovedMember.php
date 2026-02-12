<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApprovedMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isApprovedMember()) {
            return redirect()
                ->route('membership.create')
                ->withErrors(['membership' => 'Your membership is not approved yet.']);
        }

        return $next($request);
    }
}
