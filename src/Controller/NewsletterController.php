<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Subscriber as SubscriberDto;
use App\Entity\Subscriber;
use App\Repository\SubscriberRepositoryInterface;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewsletterController extends AbstractController
{
    private SubscriberRepositoryInterface $subscriberRepository;

    public function __construct(SubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * @Route("/newsletter/form", methods={"POST"}, name="app_newsletter_form")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function form(Request $request, ValidatorInterface $validator)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_newsletter_form'))
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Name'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('subscribe', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $email = $form->getData()['email'];

            $subscriberDto = new SubscriberDto($name, $email);

            $errors = $validator->validate($subscriberDto);

            if (count($errors) === 0) {
                $subscriber = Subscriber::create($subscriberDto);

                $errors = $validator->validate($subscriber);

                if (count($errors) === 0) {
                    try {
                        $this->subscriberRepository->save($subscriber);
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

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->render('newsletter/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
