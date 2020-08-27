<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HomePageArticlesProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    private HomePageArticlesProviderInterface $articlesProvider;

    public function __construct(HomePageArticlesProviderInterface $articlesProvider)
    {
        $this->articlesProvider = $articlesProvider;
    }

    /**
     * @Route("/", methods={"GET"}, name="app_home")
     */
    public function index(): Response
    {
        $articles = $this->articlesProvider->getList();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
