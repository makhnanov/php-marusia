<?php

namespace Makhnanov\PhpMarusia;

interface MarusiaResponseInterface
{
    public function __construct(MarusiaRequest $request, string $text);

    public function get(): array;

    public function answer(): void;
}
