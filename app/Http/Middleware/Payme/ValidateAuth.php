<?php

namespace App\Http\Middleware\Payme;

use App\Exceptions\Payme\AuthException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = $request->header('Authorization');
        throw_if(
            !$auth ||
            !preg_match('/^\s*Basic\s+(\S+)\s*$/i', $auth, $matches) ||
            base64_decode($matches[1]) != config('payme.login') . ":" . config('payme.key'),
            AuthException::authError()
        );


        throw_if(
            !in_array($request->ip(), config('payme.allowed_ips')),
            AuthException::authError()
        );

        return $next($request);
    }
}
