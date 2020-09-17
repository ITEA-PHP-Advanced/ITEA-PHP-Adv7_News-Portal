<?php

declare(strict_types=1);

namespace App;

use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Component\HttpFoundation\RequestStack;

final class FractalManagerFactory
{
    private string $baseUrl;

    public function __construct(RequestStack $requestStack)
    {
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    }

    public function create(): Manager
    {
        $serializer = new JsonApiSerializer($this->baseUrl);

        $manager = new Manager();
        $manager->setSerializer($serializer);

        return $manager;
    }
}
