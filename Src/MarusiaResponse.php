<?php

namespace Makhnanov\PhpMarusia;

class MarusiaResponse implements MarusiaResponseInterface
{
    public function __construct(
        protected MarusiaRequest $request,
        protected string $text,
    ) {

    }

    public function get(): array
    {
        return [];
    }

    public function answer(): void
    {
        echo '';
    }
}
