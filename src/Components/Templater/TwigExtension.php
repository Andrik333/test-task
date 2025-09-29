<?php

namespace App\Components\Templater;

use Twig\Attribute\AsTwigFunction;
use App\Components\HttpFoundation\Session;

class TwigExtension
{
    /**
     * @return bool
     */
    #[AsTwigFunction('is_auth')]
    public static function checkAuth(): bool
    {
        return Session::isAuth();
    }

    /**
     * @return string
     */
    #[AsTwigFunction('get_user_login')]
    public static function getUser(): string
    {
        $user = Session::getUser();

        return $user->getLogin();
    }
}