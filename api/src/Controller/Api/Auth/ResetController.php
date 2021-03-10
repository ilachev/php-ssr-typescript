<?php

namespace App\Controller\Api\Auth;

use App\Controller\ErrorHandler;
use App\Model\User\UseCase\Reset;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResetController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private ErrorHandler $errors,
    ) {
    }

    #[Route('/auth/reset/request', name: 'auth.reset.request', methods: ['POST'])]
    public function request(Request $request, Reset\Request\Handler $handler): Response
    {
        /** @var Reset\Request\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Reset\Request\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            return $this->json([
                'errors' => $violations,
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
            'data' => new Reset\Request\Command(),
            'status' => 'success',
            'errors' => [
                'violations' => [],
            ],
        ], 201);
    }

    #[Route('/auth/reset/confirm', name: 'auth.reset.confirm', methods: ['POST'])]
    public function confirm(
        Request $request,
        Reset\Confirm\Handler $handler
    ): Response {
        /** @var Reset\Confirm\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Reset\Confirm\Command::class, 'json');

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

    #[Route('/auth/reset', name: 'auth.reset', methods: ['POST'])]
    public function reset(
        Request $request,
        Reset\Reset\Handler $handler
    ): Response {
        /** @var Reset\Reset\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Reset\Reset\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            return $this->json([
                'errors' => $violations,
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

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
