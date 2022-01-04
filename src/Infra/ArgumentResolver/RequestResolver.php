<?php

namespace App\Infra\ArgumentResolver;

use App\Infra\Http\Request\CheckEmailVerificationRequest;
use App\Infra\Http\Request\ConstructCardRequest;
use App\Infra\Http\Request\ConstructWonderRequest;
use App\Infra\Http\Request\CreateRoomRequest;
use App\Infra\Http\Request\DiscardCardRequest;
use App\Infra\Http\Request\JoinToRoomRequest;
use App\Infra\Http\Request\LeaveRoomRequest;
use App\Infra\Http\Request\PickBoardTokenRequest;
use App\Infra\Http\Request\PickDiscardedCardRequest;
use App\Infra\Http\Request\PickRandomTokenRequest;
use App\Infra\Http\Request\PickReturnedCardsRequest;
use App\Infra\Http\Request\PickTopLineCardRequest;
use App\Infra\Http\Request\RefreshSessionRequest;
use App\Infra\Http\Request\SendEmailVerificationRequest;
use App\Infra\Http\Request\SigninRequest;
use App\Infra\Http\Request\SignupRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    private array $supported = [
        CheckEmailVerificationRequest::class => true,
        ConstructCardRequest::class => true,
        ConstructWonderRequest::class => true,
        CreateRoomRequest::class => true,
        DiscardCardRequest::class => true,
        JoinToRoomRequest::class => true,
        LeaveRoomRequest::class => true,
        PickBoardTokenRequest::class => true,
        PickDiscardedCardRequest::class => true,
        PickRandomTokenRequest::class => true,
        PickReturnedCardsRequest::class => true,
        PickTopLineCardRequest::class => true,
        RefreshSessionRequest::class => true,
        SendEmailVerificationRequest::class => true,
        SigninRequest::class => true,
        SignupRequest::class => true,
    ];

    public function __construct(
        private ValidatorInterface $validator,
    )
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return isset($this->supported[$argument->getType()]);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $class = $argument->getType();
        $dto = new $class($this->extractParams($request), $request->cookies);

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            throw new BadRequestHttpException($errors->get(0)->getMessage());
        }

        yield $dto;
    }

    protected function extractParams(Request $request): array
    {
        if ($request->getMethod() === Request::METHOD_GET) {
            return $request->query->all();
        }

        return json_decode($request->getContent(), true);
    }
}
