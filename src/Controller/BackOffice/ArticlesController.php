<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

use App\Dto\CreateArticle;
use App\Service\ArticleAuthorInterface;
use App\Transformer\ArticleTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/articles")
 */
final class ArticlesController extends AbstractController
{
    private ArticleAuthorInterface $articleAuthor;
    private ValidatorInterface $validator;
    private Manager $fractal;

    public function __construct(Manager $fractal, ArticleAuthorInterface $articleAuthor, ValidatorInterface $validator)
    {
        $this->articleAuthor = $articleAuthor;
        $this->validator = $validator;
        $this->fractal = $fractal;
    }

    /**
     * @Route(methods={"GET"}, name="app_back_office_articles_list")
     */
    public function list(): JsonResponse
    {
        $articles = $this->articleAuthor->getList();
        $resource = new Collection($articles, new ArticleTransformer(), 'articles');

        return new JsonResponse($this->fractal->createData($resource));
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"GET"}, name="app_back_office_articles_view")
     */
    public function view(int $id): JsonResponse
    {
        $article = $this->articleAuthor->getById($id);
        $resource = new Item($article, new ArticleTransformer(), 'articles');

        return new JsonResponse($this->fractal->createData($resource));
    }

    /**
     * @Route(methods={"POST"}, name="app_back_office_articles_create")
     */
    public function create(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true);
        $dto = CreateArticle::fromRequest($data);

        $violations = $this->validator->validate($dto);

        if (\count($violations) > 0) {
            $errors = [];

            foreach ($violations as $violation) {
                $errors[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                    'code' => $violation->getCode(),
                ];
            }

            return new JsonResponse($errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        $article = $this->articleAuthor->create($dto);
        $resource = new Item($article, new ArticleTransformer(), 'articles');

        return new JsonResponse($this->fractal->createData($resource));
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"DELETE"}, name="app_back_office_articles_delete")
     */
    public function delete(int $id): JsonResponse
    {
        $this->articleAuthor->delete($id);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
