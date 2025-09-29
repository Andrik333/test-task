<?php

namespace App\Controllers;

use App\Components\ORM\Doctrine;
use App\Components\Templater\Twig;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class BaseController
{
    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->twig = (new Twig($this->request))->init();
        $this->entityManager = (new Doctrine($_SERVER['PROJECT_ROOT']))->init();
    }
}
