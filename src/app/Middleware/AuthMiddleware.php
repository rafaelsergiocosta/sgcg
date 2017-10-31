<?php

namespace App\Middleware;

class AuthMiddleware
{
    protected $options = [
        "passthrough" => ["OPTIONS"]
    ];

    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    public function __invoke($request, $response, $next)
    {
        if (!isset($_SESSION['user'])) {
            $path = $request->getUri();
            if (!in_array($path->getPath(), $this->options['passthrough'])) {
                return $response->withStatus(401);
            }
        }

        $response = $next($request, $response);

        return $response;
    }
}