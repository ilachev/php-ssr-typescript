<?php

declare(strict_types=1);

namespace App\Controller\Api\Auth;

use App\Controller\ErrorHandler;
use App\Model\User\UseCase\SignUp;
use App\ReadModel\User\UserFetcher;
use DomainException;
use OpenApi\Annotations as OA;
use ReCaptcha\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignUpController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private UserFetcher $users,
        private ErrorHandler $errors,
    ) {
    }

    #[Route('/auth/signup', name: 'auth.signup', methods: ['POST'])]
    public function request(Request $request, SignUp\Request\Handler $handler, ReCaptcha $captcha): Response
    {
        /** @var SignUp\Request\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), SignUp\Request\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            return $this->json([
                'errors' => $violations,
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        $resp = $captcha->verify($command->token);
        if (!$resp->isSuccess()) {
            return $this->json([
                'errors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'token',
                            'title' => '',
                        ],
                    ],
                ],
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        try {
            $handler->handle($command);
        } catch (DomainException $e) {
            return $this->json([
                'errors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'email',
                            'title' => $e->getMessage(),
                        ],
                    ],
                ],
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        return $this->json([
            'data' => new SignUp\Request\Command(),
            'status' => 'success',
            'errors' => [
                'violations' => [],
            ],
        ], 201);
    }

    #[Route('/auth/confirm', name: 'auth.confirm', methods: ['POST'])]
    public function confirm(
        Request $request,
        SignUp\Confirm\ByToken\Handler $handler
    ): Response {
        /** @var SignUp\Confirm\ByToken\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), SignUp\Confirm\ByToken\Command::class, 'json');

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);

            return $this->json([
                'errors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'token',
                            'title' => $e->getMessage(),
                        ],
                    ],
                ],
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        return $this->json([
            'data' => $command,
            'status' => 'success',
            'errors' => [
                'violations' => [],
            ],
        ], 201);
    }
}

/*
 * @OA\Post(
 *     path="/auth/signup",
 *     tags={"Sign Up"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"first_name", "last_name", "email", "password"},
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Success response",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Errors",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
 *     ),
 * )
 */
