<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Subscriber as SubscriberDto;
use App\Entity\Subscriber;
use App\Form\SubscriptionType;
use App\Repository\SubscriberRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class NewsletterController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/newsletter/form", methods={"POST"}, name="app_newsletter_form")
     *
     * @return Response
     */
    public function form(Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(SubscriptionType::class, null, [
            'action' => $this->generateUrl('app_newsletter_form')
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subscriberDto = $form->getData();

            $errors = $validator->validate($subscriberDto);

            if (0 === count($errors)) {
                $subscriber = new Subscriber($subscriberDto);

                $errors = $validator->validate($subscriber);

                if (0 === count($errors)) {
                    try {
                        $this->em->persist($subscriber);
                        $this->em->flush();
                    } catch (ORMException $e) {
                        $this->addFlash('error', $e->getMessage());
                    }
                } else {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }
                }
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
