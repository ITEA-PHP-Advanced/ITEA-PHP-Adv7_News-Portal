<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController
{
    /**
     * @Route("/", methods={"GET"}, name="app_home")
     */
    public function index(): Response
    {
        return new Response('<h1>Hello from Symfony app!</h1>');
    }
}
