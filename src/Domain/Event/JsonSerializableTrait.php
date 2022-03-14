<?php

namespace App\Domain\Event;

trait JsonSerializableTrait
{
    /**
     * Convert whatever object is using this trait into an array.
     *
     * @noinspection PhpUnused
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}