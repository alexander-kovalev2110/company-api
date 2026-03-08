<?php

namespace App\ArgumentResolver;

use App\DTO\ProjectRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class ProjectRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== ProjectRequest::class) {
            return [];
        }

        yield $this->serializer->deserialize(
            $request->getContent(),
            ProjectRequest::class,
            'json'
        );
    }
}
