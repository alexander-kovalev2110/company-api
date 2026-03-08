<?php

namespace App\ArgumentResolver;

use App\DTO\EmployeeRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeeRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== EmployeeRequest::class) {
            return [];
        }

        yield $this->serializer->deserialize(
            $request->getContent(),
            EmployeeRequest::class,
            'json'
        );
    }
}
