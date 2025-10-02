<?php

namespace App\Controllers\Api;

use App\Entity\Post;
use App\Components\Routes\Route;
use App\Components\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlogApiController extends BaseApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/api/blogs', name: 'api_blogs', methods: ['POST'])]
    public function login(): JsonResponse
    {
        if (!Session::isAuth()) {
            return new JsonResponse(['message' => 'Доступно только авторизованным пользователям'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $currentPage = intval($this->request->request->get('page', 1));

        try {
            $posts = $this->entityManager->getRepository(Post::class)->getPosts();

            $responseData = [
                'message' => 'Ok',
                'data' => [
                    'total' => intval($_ENV['POSTS_COUNT']),
                    'pages' => ceil($_ENV['POSTS_COUNT'] / 12),
                    'currentPage' => $currentPage,
                    'posts' => $posts
                ]
            ];

            return new JsonResponse($responseData);
        } catch (\Throwable $th) {
            $responseData['message'] = $th->getMessage();

            return new JsonResponse($responseData, $th->getCode());
        }
    }
}
