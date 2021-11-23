<?php

namespace Makhnanov\PhpMarusia\Exception;

trait ProbablyBadRequest
{
    /**
     * @throws BadRequest
     */
    protected function throwException($property): void
    {
        throw new BadRequest("Property $property is not set in " . __CLASS__ . ' constructor.');
    }
}
