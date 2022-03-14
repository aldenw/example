<?php

namespace App\Domain\Model;

use App\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];

    /**
     * @return DomainEvent[]
     */
    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = array();

        return $events;
    }

    protected function raise(DomainEvent $event)
    {
        $this->events[] = $event;
    }
}