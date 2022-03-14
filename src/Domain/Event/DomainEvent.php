<?php

namespace App\Domain\Event;

use JsonSerializable;

abstract class DomainEvent implements JsonSerializable
{
    use JsonSerializableTrait;

    private string $aggregateClass;
    private mixed $aggregateId;

    public function setAggregate(string $aggregateClass, $id)
    {
        $this->aggregateClass = $aggregateClass;
        $this->aggregateId = $id;
    }

    public function getAggregateClass(): string
    {
        return $this->aggregateClass;
    }

    public function getAggregateId(): mixed
    {
        return $this->aggregateId;
    }
}