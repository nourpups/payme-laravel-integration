<?php

namespace App\Http\Middleware\Payme;

use App\Exceptions\Payme\HttpException;
use App\Exceptions\Payme\JsonException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        throw_if(
            $request->method() !== 'POST',
           HttpException::invalidHttpMethod()
        );

        throw_if(
            empty($request['method']) || empty($request['params']),
            JsonException::jsonRpcError()
        );

        throw_if(
            in_array($request['method'], \App\Enum\Payme\Method::toArray()),
            HttpException::methodNotFound()
        );

        return $next($request);
    }
}
