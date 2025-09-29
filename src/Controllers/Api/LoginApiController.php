<?php

namespace App\Controllers\Api;

use App\Entity\User;
use App\Components\Routes\Route;
use App\Components\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginApiController extends BaseApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        if (Session::isAuth()) {
            return new JsonResponse(['message' => 'Вы уже авторизованы', 'redirect' => '/']);
        }

        $login = htmlspecialchars(
            trim($this->request->request->get('login'))
        );

        $password = htmlspecialchars(
            trim($this->request->request->get('password'))
        );
        
        try {
            if (!$login || !$password) {
                throw new \Exception('Введены некорректные учетные данные', JsonResponse::HTTP_BAD_REQUEST);
            }

            /** @var User|null */
            $user = $this->entityManager->getRepository(User::class)->getUser($login);

            if (!$user) {
                throw new \Exception(sprintf('Пользователь с логином "%s" не зарегистрирован', $login), JsonResponse::HTTP_NOT_FOUND);
            }

            if ($password !== $user->getPassword()) {
                throw new \Exception('Не верный пароль', JsonResponse::HTTP_BAD_REQUEST);
            }

            Session::start($user->getId());

            return new JsonResponse(['message' => 'Ok', 'redirect' => '/']);
        } catch (\Throwable $th) {
            $responseData['message'] = $th->getMessage();

            return new JsonResponse($responseData, $th->getCode());
        }
    }

    /**
     * @return JsonResponse
     */
    #[Route('/api/registration', name: 'api_registration', methods: ['POST'])]
    public function registraion(): JsonResponse
    {
        if (Session::isAuth()) {
            return new JsonResponse(['message' => 'Вы уже авторизованы', 'redirect' => '/']);
        }

        $login = htmlspecialchars(
            trim($this->request->request->get('login'))
        );

        $password = htmlspecialchars(
            trim($this->request->request->get('password'))
        );

        try {
            if (!$login || !$password) {
                throw new \Exception('Введены некорректные учетные данные', JsonResponse::HTTP_BAD_REQUEST);
            }

            $user = $this->entityManager->getRepository(User::class)->getUser($login);

            if ($user) {
                throw new \Exception('Пользователь с таким логином уже зарегистрирован', JsonResponse::HTTP_BAD_REQUEST);
            }

            $user = new User();
            $user->setLogin($login)->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $responseData = [
                'message' => sprintf('Регистрация прошла успешно. Используйте логин "%s" для входа', $login)
            ];

            return new JsonResponse($responseData);
        } catch (\Throwable $th) {
            $responseData['message'] = $th->getMessage();

            return new JsonResponse($responseData, $th->getCode());
        }
    }

    /**
     * @return JsonResponse
     */
    #[Route('/api/show-password', name: 'api_show_password', methods: ['POST'])]
    public function showPassword(): JsonResponse
    {
        if (Session::isAuth()) {
            return new JsonResponse(['message' => 'Вы уже авторизованы', 'redirect' => '/']);
        }

        $login = htmlspecialchars(
            trim($this->request->request->get('login'))
        );

        try {
            if (!$login) {
                throw new \Exception('Логин не введен', JsonResponse::HTTP_BAD_REQUEST);
            }

            /** @var User|null */
            $user = $this->entityManager->getRepository(User::class)->getUser($login);

            if (!$user) {
                throw new \Exception('Пользователь с таким логином не зарегистрирован', JsonResponse::HTTP_NOT_FOUND);
            }

            $responseData = [
                'message' => sprintf('Ваш пароль "%s"', $user->getPassword())
            ];

            return new JsonResponse($responseData);
        } catch (\Throwable $th) {
            $responseData['message'] = $th->getMessage();

            return new JsonResponse($responseData, $th->getCode());
        }
    }
}
