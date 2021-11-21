<?php

namespace Makhnanov\PhpMarusia;

use Closure;

class MarusiaRequestMiddlewareCollection
{
    protected array $collection = [];

    protected function __construct()
    {
    }

    public function create(): self
    {
        return new self;
    }

    public function add(MarusiaRequestMiddlewareEnum $requestMiddlewareEnum, Closure $middleware): self
    {
        $this->collection[$requestMiddlewareEnum->name] = $middleware;
        return $this;
    }

    public function execute(MarusiaRequestMiddlewareEnum $requestMiddlewareEnum, MarusiaRequest &$request): mixed
    {
        return $this->collection[$requestMiddlewareEnum->name]($request);
    }
}
