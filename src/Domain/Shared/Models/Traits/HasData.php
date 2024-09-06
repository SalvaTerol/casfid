<?php

namespace Domain\Shared\Models\Traits;

trait HasData
{
    public function getData()
    {
        $dataClass = match (true) {
            property_exists($this, 'dataClass') => $this->dataClass,
            method_exists($this, 'dataClass') => $this->dataClass(),
            default => null,
        };

        if (! class_exists($dataClass) || ! method_exists($dataClass, 'fromModel')) {
            throw new InvalidArgumentException("Invalid or missing data class: {$dataClass}");
        }

        return $dataClass::fromModel($this);
    }
}
