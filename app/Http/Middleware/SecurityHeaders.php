<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->setIfMissing($response, 'X-Content-Type-Options', 'nosniff');
        $this->setIfMissing($response, 'X-Frame-Options', 'DENY');
        $this->setIfMissing($response, 'Referrer-Policy', 'strict-origin-when-cross-origin');
        $this->setIfMissing($response, 'Permissions-Policy', 'camera=(), geolocation=(), microphone=()');
        $this->setIfMissing(
            $response,
            'Content-Security-Policy',
            "base-uri 'self'; object-src 'none'; frame-ancestors 'none'; form-action 'self'",
        );

        if (config('app.env') === 'production' && $request->isSecure()) {
            $this->setIfMissing($response, 'Strict-Transport-Security', 'max-age=31536000');
        }

        return $response;
    }

    private function setIfMissing(Response $response, string $name, string $value): void
    {
        if (! $response->headers->has($name)) {
            $response->headers->set($name, $value);
        }
    }
}
