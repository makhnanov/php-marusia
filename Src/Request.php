<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\InvalidAuthId;
use Makhnanov\PhpMarusia\Request\Meta;
use Makhnanov\PhpMarusia\Request\RequestProperty;
use Makhnanov\PhpMarusia\Request\Session;
use Makhnanov\PhpSelfFilling\SelfFilling;
use Throwable;

/**
 * Официальную документацию можно найти по адресу
 * @url https://vk.com/dev/marusia_skill_docs8
 */
class Request
{
    use SelfFilling;

    /**
     * @description Информация об устройстве, с помощью которого пользователь общается с Марусей
     */
    public readonly Meta $meta;

    /**
     * @description Данные, полученные от пользователя
     */
    public readonly RequestProperty $request;

    /**
     * @description Данные о сессии
     */
    public readonly Session $session;

    /**
     * @description Версия протокола, текущая версия — 1.0.
     */
    public readonly string $version;

    /**
     * Принятие и обработка запроса от сервера маруси
     *
     * @throws BadRequest
     * @throws InvalidAuthId
     */
    public static function handle(null|string $authToken): self
    {
        return new self(
            Tools::receiveData() ?: throw new BadRequest('Data is empty.'),
            $authToken
        );
    }

    /**
     * @throws BadRequest
     * @throws InvalidAuthId
     */
    protected function __construct(string $data, null|string $authToken)
    {
        try {
            $this->selfFill($data);
        } catch (Throwable $e) {
            throw new BadRequest('Wrong type.', previous: $e);
        }

        if (is_null($authToken)) {
            return;
        }

        $receivedAuthToken = $this->session->authToken;
        if ($receivedAuthToken !== $authToken) {
            throw new InvalidAuthId("Auth token \"$receivedAuthToken\" invalid");
        }
    }

    public function isVoice(): bool
    {
        return $this->request->type === 'SimpleUtterance';
    }

    public function isButton(): bool
    {
        return $this->request->type === 'ButtonPressed';
    }

    public function isStart(): bool
    {
        return $this->session->new === true;
    }

    public function isEnd(): bool
    {
        return $this->request->command === 'on_interrupt';
    }

    public function response(): Response
    {
        return Response::create()->setRequest($this);
    }
}
