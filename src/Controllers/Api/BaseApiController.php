<?php

namespace App\Controllers\Api;

use App\Components\ORM\Doctrine;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class BaseApiController
{
    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->entityManager = (new Doctrine($_SERVER['PROJECT_ROOT']))->init();
    }
}
