<?php

namespace App\Controller\Api\Profile;

use App\ReadModel\User\UserFetcher;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function show(UserFetcher $users): Response
    {
        $user = $users->get($this->getUser()->getId());

        return $this->json([
            'id' => $user->getId()->getValue(),
            'email' => $user->getEmail()->getValue(),
            'avatar' => [
                'url' => sprintf(
                    '//gravatar.com/avatar/%s?s=40&d=wavatar',
                    md5($user->getEmail()->getValue())
                ),
            ],
            'name' => $user->getName()->getFull(),
        ]);
    }
}

/*
 * @OA\Get(
 *     path="/profile",
 *     tags={"Profile"},
 *     @OA\Response(
 *         response=200,
 *         description="Success response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="name", type="object",
 *                 @OA\Property(property="first", type="string"),
 *                 @OA\Property(property="last", type="string"),
 *             )
 *         )
 *     ),
 *     security={{"oauth2": {"common"}}}
 * )
 */
