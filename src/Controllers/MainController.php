<?php

namespace App\Controllers;

use App\Components\Routes\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Components\HttpFoundation\Session;

class MainController extends BaseController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        if (!Session::isAuth()) {
            return new RedirectResponse('/login');
        }

        return new Response(
            $this->twig->render('pageMain.html.twig')
        );
    }

    /**
     * @return Response
     */
    #[Route('/login', name: 'login', methods: ['GET'])]
    public function login(): Response
    {
        if (Session::isAuth()) {
            return new RedirectResponse('/');
        }

        return new Response(
            $this->twig->render('pageLogin.html.twig')
        );
    }

    /**
     * @return RedirectResponse
     */
    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): RedirectResponse
    {
        if (!Session::isAuth()) {
            return new RedirectResponse('/login');
        }

        Session::close();

        return new RedirectResponse('/login');
    }

    /**
     * @return Response
     */
    #[Route('/show-password', name: 'show_password', methods: ['GET'])]
    public function showPassword(): Response
    {
        if (Session::isAuth()) {
            return new RedirectResponse('/');
        }

        return new Response(
            $this->twig->render('pageShowPassword.html.twig')
        );
    }
}
