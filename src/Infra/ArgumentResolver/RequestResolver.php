<?php

namespace App\Infra\ArgumentResolver;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    private array $supported = [

    ];

    public function __construct(
        private ValidatorInterface $validator,
    )
    {
    }

    #[Pure] public function supports(Request $request, ArgumentMetadata $argument): bool
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
