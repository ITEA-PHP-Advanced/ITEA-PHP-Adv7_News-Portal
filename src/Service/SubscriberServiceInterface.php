<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Subscriber as SubscriberDto;

interface SubscriberServiceInterface
{
    public function create(SubscriberDto $dto): void;
}
