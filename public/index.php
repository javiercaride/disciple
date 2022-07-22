<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(false, true, true);

$afterMiddleware = function (Request $request, RequestHandler$handler) {
    $response = $handler->handle($request);
    return $response->withHeader('Custom-Header', 'v1');
};
$app->add($afterMiddleware);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/goodbye', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Goodbye world!");
    return $response;
});

$app->run();