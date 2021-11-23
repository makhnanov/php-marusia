<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia;

use JetBrains\PhpStorm\ArrayShape;
use Makhnanov\PhpMarusia\Exception\BadResponse;
use Stringable;

class Response
{
    protected ?Request $request;

    protected Stringable|string $text = '';

    protected Stringable|string $tts = '';

    protected bool $endSession = false;

    private array $buttons = [];

    private string $userId = '';

    private string $sessionId = '';

    private ?int $messageId = null;

    private string $version = '';

    protected function __construct()
    {
    }

    public static function create(): self
    {
        return new self;
    }

    public function setText(string|Stringable $text): self
    {
        $this->text = (string)$text;
        return $this;
    }

    public function setTts(string|Stringable $tts): self
    {
        $this->tts = (string)$tts;
        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function setUserId(string $id): self
    {
        $this->userId = $id;
        return $this;
    }

    /**
     * @throws BadResponse
     */
    private function getUserId(): string
    {
        return $this->userId
            ?: $this->request?->getSession()->getApplication()->getApplicationId()
                ?: throw new BadResponse('Need fill session.user_id');
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @throws BadResponse
     */
    private function getSessionId(): string
    {
        return $this->sessionId
            ?: $this->request?->getSession()->getSessionId()
                ?: throw new BadResponse('sessionId is not set');
    }

    private function setMessageId(int $messageId): self
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @throws BadResponse
     */
    private function getMessageId(): int
    {
        return $this->messageId
            ?: $this->request?->getSession()->getMessageId()
                ?: throw new BadResponse('messageId is no set');
    }

    /**
     * @throws BadResponse
     */
    private function getVersion(): string
    {
        return $this->version
            ?: $this->request?->getVersion()
                ?: throw new BadResponse('version in not set');
    }

    public function appendButton(Stringable|string $title, ?string $url = null, ?array $payload = null): self
    {
        $this->buttons[] = array_filter(compact('title', 'url', 'payload'));
        return $this;
    }

    public function prependButton(Stringable|string $title, ?string $url = null, ?array $payload = null): self
    {
        $this->buttons = [
            array_filter(compact('title', 'url', 'payload')),
            ...$this->buttons,
        ];
        return $this;
    }

    public function setEndSession(bool $endSession): self
    {
        $this->endSession = $endSession;
        return $this;
    }

    /**
     * @throws BadResponse|BadResponse
     */
    #[ArrayShape(['response' => "array", 'session' => "array", 'version' => ""])]
    public function getData(): array
    {
        $response = [
            'response' => [
                'text' => $this->text ?: throw new BadResponse('Text is not set or empty'),
                'tts' => $this->tts ?: $this->text,
                'end_session' => $this->endSession,
            ],
            'session' => [
                'user_id' => $this->getUserId(),
                'session_id' => $this->getSessionId(),
                'message_id' => $this->getMessageId(),
            ],
            'version' => $this->getVersion()
        ];
        if ($this->buttons) {
            $response['response']['buttons'] = $this->buttons;
        }
        return $response;
    }

    /**
     * @throws BadResponse
     */
    public function say(): void
    {
        echo json_encode($this->getData());
    }
}
