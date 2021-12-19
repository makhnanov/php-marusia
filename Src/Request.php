<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\InvalidAuthId;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use Makhnanov\PhpMarusia\Request\Meta;
use Makhnanov\PhpMarusia\Request\RequestProperty;
use Makhnanov\PhpMarusia\Request\Session;
use TypeError;

/**
 * Официальную документацию можно найти по адресу
 * @url https://vk.com/dev/marusia_skill_docs8
 *
 * @method Meta getMeta()
 * @method RequestProperty getRequest()
 * @method Session getSession()
 * @method string getVersion()
 */
class Request
{
    use ProbablyBadRequest, Getter;

    /**
     * @description Информация об устройстве, с помощью которого пользователь общается с Марусей
     */
    protected Meta $meta;

    /**
     * @description Данные, полученные от пользователя
     */
    protected RequestProperty $request;

    /**
     * @description Данные о сессии
     */
    protected Session $session;

    /**
     * @description Версия протокола, текущая версия — 1.0.
     */
    protected string $version;

    /**
     * @throws BadRequest
     * @throws InvalidAuthId
     */
    public static function handle(string $data, null|string $authToken = null, bool $validateAuthToken = true)
    {
        return new self(...func_get_args());
    }

    /**
     * @throws BadRequest
     * @throws InvalidAuthId
     */
    protected function __construct(string $data, null|string $authToken = null, bool $validateAuthToken = true)
    {
        try {
            $dataObject = json_decode($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new BadRequest(__CLASS__ . ' received bad json. Json error: ' . json_last_error_msg());
            }
            $this->meta = new Meta($dataObject->meta ?? $this->throwException('meta'));
            $this->request = new RequestProperty($dataObject->request ?? $this->throwException('request'));
            $this->session = new Session($dataObject->session ?? $this->throwException('session'));
            /** @noinspection PhpStrictTypeCheckingInspection */
            $this->version = $dataObject->version ?? $this->throwException('version');

        } catch (TypeError $e) {
            throw new BadRequest('Wrong type.', previous: $e);
        }

        if (!$validateAuthToken) {
            return;
        }

        $receivedAuthToken = $this->session->getAuthToken();
        if ($receivedAuthToken !== $authToken) {
            throw new InvalidAuthId("Auth token \"$receivedAuthToken\" invalid");
        }
    }

    public function isVoice(): bool
    {
        return $this->request->getType() === 'SimpleUtterance';
    }

    public function isButton(): bool
    {
        return $this->request->getType() === 'ButtonPressed';
    }

    public function isStart(): bool
    {
        return $this->session->getNew() === true;
    }

    public function isEnd(): bool
    {
        return $this->request->getCommand() === 'on_interrupt';
    }
}
