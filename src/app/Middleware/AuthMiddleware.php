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
            $path = $request->getUri()->getPath();
            if (
                !in_array($path, $this->options['passthrough']) 
                    &&
                !$this->containsPath($path, $this->options['passthrough'])
                ) {
                return $response->withRedirect("/login");
            }
        }

        $response = $next($request, $response);

        return $response;
    }

    private function containsPath($path, $array)
    {
        foreach ($array as $item) {
            if (strpos($item, '/*')) {
                $item = str_replace("*", "", $item);
                if (strpos($path, $item) !== false) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }
}