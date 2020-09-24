<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\EntityNotFoundException;
use App\Service\ArticlePresentationInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ArticleController extends AbstractController
{
    private ArticlePresentationInterface $articlePresentation;
    private LoggerInterface $logger;

    public function __construct(ArticlePresentationInterface $articlePresentation, LoggerInterface $logger)
    {
        $this->articlePresentation = $articlePresentation;
        $this->logger = $logger;
    }

    /**
     * @Route("/article/{id}", requirements={"id": "\d+"}, methods={"GET"}, name="app_article_view")
     */
    public function view(int $id): Response
    {
        try {
            $article = $this->articlePresentation->getById($id);
        } catch (EntityNotFoundException $e) {
            $this->logger->error($e->getMessage(), [
                'exception' => $e,
            ]);

            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render('article/view.html.twig', [
            'article' => $article,
        ]);
    }
}
