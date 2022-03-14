<?php

/** @noinspection PhpUnused */

namespace App\Integration\Database\EventListener;

use App\Domain\Model\AggregateRoot;
use Symfony\Component\Messenger\MessageBusInterface;

class DomainEventListener
{
    /**
     * @var AggregateRoot[]
     */
    private array $entities = [];

    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function postPersist($event)
    {
        $this->keepAggregateRoots($event);
    }

    public function postUpdate($event)
    {
        $this->keepAggregateRoots($event);
    }

    public function postRemove($event)
    {
        $this->keepAggregateRoots($event);
    }

    public function postFlush($event)
    {
        $entityManager = $event->getEntityManager();

        foreach ($this->entities as $entity) {
            $class = $entityManager->getClassMetadata(get_class($entity));

            foreach ($entity->popEvents() as $event) {
                $event->setAggregate($class->name, $class->getSingleIdReflectionProperty()->getValue($entity));
                $this->eventBus->dispatch($event);
            }
        }
        $this->entities = [];
    }

    private function keepAggregateRoots($event)
    {
        $entity = $event->getEntity();

        if (!($entity instanceof AggregateRoot)) {
            return;
        }

        $this->entities[] = $entity;
    }
}