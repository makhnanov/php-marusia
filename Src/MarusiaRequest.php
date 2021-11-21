<?php

namespace Makhnanov\PhpMarusia;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use stdClass;
use Stringable;

class MarusiaRequest
{
    protected array $properties = [];

    protected string $responseClass = MarusiaResponse::class;

    public static function handle(
        ?MarusiaRequestMiddlewareCollection $collection = null,
        LoggerInterface                     $logger = new NullLogger()
    ): self {
        return new self(self::getData(), $logger, $collection);
    }

    protected static function getData(): object|array
    {
        return json_decode(file_get_contents('php://input'));
    }

    protected function __construct(
        protected stdClass                            $requestData,
        protected LoggerInterface                     $logger,
        protected ?MarusiaRequestMiddlewareCollection $middlewareCollection = null,
    ) {
        $this->logger->info('Start handle marusia request via {marusiaHandler} class with {logger} logger.', [
            'marusiaHandler' => get_class($this),
            'logger' => get_class($logger),
        ]);

        $this->logger->debug('Request object received: {request}', [
            'request' => MarusiaTools::getOutputBuffer($requestData)
        ]);

        $debugText = 'Execute {order} validate request middleware. Result: {result}';

        $this->logger->debug($debugText, [
            'order' => 'before',
            'result' => $this->getMiddlewareResult(MarusiaRequestMiddlewareEnum::BEFORE_VALIDATE),
        ]);

        $this->validate();

        $this->logger->debug($debugText, [
            'order' => 'after',
            'result' => $this->getMiddlewareResult(MarusiaRequestMiddlewareEnum::AFTER_VALIDATE),
        ]);
    }

    protected function validate()
    {

    }

    public function response(string|Stringable $text): MarusiaResponseInterface
    {
        return new $this->responseClass($this, (string)$text);
    }

    protected function getMiddlewareResult(MarusiaRequestMiddlewareEnum $enum): string
    {
        return $this->middlewareCollection
            ? MarusiaTools::getOutputBuffer(
                $this->middlewareCollection->execute($enum, $this)
            )
            : 'Middleware collection is not set.';
    }
}
