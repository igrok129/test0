<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetApiHeaders
{
    /**
     * Setting headers for request, that are needed.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response|JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        $request->headers->set('accept', 'application/json');

        return $next($request);
    }
}
