<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Subscriber;

interface SubscriberRepositoryInterface
{
    public function save(Subscriber $subscriber): void;
}
