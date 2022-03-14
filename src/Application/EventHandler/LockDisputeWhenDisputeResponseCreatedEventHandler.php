<?php

namespace App\Application\EventHandler;

use App\Domain\Event\DisputeResponseCreatedEvent;
use App\Domain\Repository\DisputeRepositoryInterface;
use App\Domain\Repository\DisputeResponseRepositoryInterface;

class LockDisputeWhenDisputeResponseCreatedEventHandler
{
    private DisputeResponseRepositoryInterface $responseRepository;
    private DisputeRepositoryInterface $disputeRepository;

    public function __invoke(DisputeResponseCreatedEvent $event)
    {
        $response = $this->responseRepository->find($event->getAggregateId());

        if(isset($response)) {
            $dispute = $response->getDispute();

        }
    }
}