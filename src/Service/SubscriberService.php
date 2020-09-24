<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Subscriber as SubscriberDto;
use App\Entity\Subscriber;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final class SubscriberService implements SubscriberServiceInterface
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger
    ) {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function create(SubscriberDto $dto): void
    {
        $subscriber = new Subscriber($dto);

        try {
            $this->em->persist($subscriber);
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
