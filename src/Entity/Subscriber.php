<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\Subscriber as SubscriberDto;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriberRepository::class)
 */
class Subscriber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    public function __construct(SubscriberDto $dto)
    {
        $this->name = $dto->getName();
        $this->email = $dto->getEmail();
    }
}
