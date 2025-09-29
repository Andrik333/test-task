<?php

namespace App\Components\HttpFoundation;

use App\Entity\User;
use App\Components\ORM\Doctrine;
use Doctrine\ORM\EntityManager;

class Session
{
    /**
     * @param int $userId
     */
    public static function start(int $userId): void
    {
        $_SESSION['user_id'] = $userId;
    }

    public static function close(): void
    {
        unset($_SESSION['user_id']);
    }

    /**
     * @return bool
     */
    public static function isAuth(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * @return User|null
     */
    public static function getUser(): ?User
    {
        $user = null;

        if (self::isAuth()) {
            /** @var EntityManager */
            $entityManager = (new Doctrine($_SERVER['PROJECT_ROOT']))->init();

            $user = $entityManager->getRepository(User::class)->find($_SESSION['user_id']);
        }

        return $user;
    }
}
