<?php

namespace App\ArgumentResolver;

use App\DTO\CompanyRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== CompanyRequest::class) {
            return [];
        }

        yield $this->serializer->deserialize(
            $request->getContent(),
            CompanyRequest::class,
            'json'
        );
    }
}