<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \App\Middleware\AuthMiddleware([
    "passthrough" => ["/", "/login"]
]));