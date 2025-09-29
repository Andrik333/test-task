<?php

namespace App\Components\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Components\Routes\Router;
use App\Components\Templater\Twig;
use App\Controllers\MainController;
use App\Controllers\Api\BlogApiController;
use App\Controllers\Api\LoginApiController;
use Twig\Environment;

class Application
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response|null
     */
    protected ?Response $response = null;

    /**
     * @var Router
     */
    protected Router $router;

    /**
     * @var Environment
     */
    protected Environment $twig;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->router = new Router([MainController::class, BlogApiController::class, LoginApiController::class]);
        $this->twig = (new Twig())->init();

        session_start();
    }

    public function run()
    {
        try {
            if ($match = $this->router->match()) {
                $controller = new $match['class']();
                $this->response = $controller->{$match['method']}($match['params']);
            } else {
               throw new \Exception('Page not found', Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            $code = $th->getCode();

            if ($code < 100 || $code >= 600) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            $message = Response::$statusTexts[$code];
            $content = $this->twig->render('pageError.html.twig',[
                'code' => $code,
                'message' => $message
            ]);

            $this->response = new Response($content, $code);
        }

        $this->response->send();
        exit();
    }
}
