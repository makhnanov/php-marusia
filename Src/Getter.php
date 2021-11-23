<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia;

use InvalidArgumentException;

trait Getter
{
    public function __call(string $name, array $arguments)
    {
        $propertyName = lcfirst(
            preg_replace(
                '/^get/',
                '',
                $name
            )
        );
        if (property_exists($this, $propertyName)) {
            return $this->$propertyName;
        }
        throw new InvalidArgumentException("Property $propertyName not found in " . __CLASS__);
    }
}
