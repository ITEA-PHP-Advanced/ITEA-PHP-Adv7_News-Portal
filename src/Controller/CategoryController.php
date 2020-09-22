<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\EntityNotFoundException;
use App\Exception\UserDoesNotHaveSubscriptionException;
use App\Service\CategoryPresentationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryController extends AbstractController
{
    private CategoryPresentationInterface $categoryPresentation;

    public function __construct(CategoryPresentationInterface $categoryPresentation)
    {
        $this->categoryPresentation = $categoryPresentation;
    }

    /**
     * @Route("/c/{slug}", requirements={"slug": "^[a-z0-9]+(?:-[a-z0-9]+)*$"}, methods={"GET"}, name="app_category")
     */
    public function index(string $slug): Response
    {
        try {
            $category = $this->categoryPresentation->getBySlug($slug);
        } catch (EntityNotFoundException | UserDoesNotHaveSubscriptionException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }

    public function list(): Response
    {
        $categories = $this->categoryPresentation->getMenuItems();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
