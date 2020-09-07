<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\SubscriptionType;
use App\Service\SubscriberServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class NewsletterController extends AbstractController
{
    private SubscriberServiceInterface $subscriberService;

    public function __construct(SubscriberServiceInterface $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    /**
     * @Route("/newsletter/form", methods={"POST"}, name="app_newsletter_form")
     */
    public function form(Request $request, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(SubscriptionType::class, null, [
            'action' => $this->generateUrl('app_newsletter_form'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $form->getErrors();

            if (0 === count($errors)) {
                $this->subscriberService->create($form->getData());
            } else {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('newsletter/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
