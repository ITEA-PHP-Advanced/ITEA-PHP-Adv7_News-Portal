<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\EntityNotFoundException;
use App\Service\ArticlePresentationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ArticleController extends AbstractController
{
    private ArticlePresentationInterface $articlePresentation;

    public function __construct(ArticlePresentationInterface $articlePresentation)
    {
        $this->articlePresentation = $articlePresentation;
    }

    /**
     * @Route("/article/{id}", requirements={"id": "\d+"}, methods={"GET"}, name="app_article_view")
     */
    public function view(int $id): Response
    {
        try {
            $article = $this->articlePresentation->getById($id);
        } catch (EntityNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render('article/view.html.twig', [
            'article' => $article,
        ]);
    }
}
