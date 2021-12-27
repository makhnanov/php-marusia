<?php

namespace Makhnanov\PhpMarusia\Request\Session;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpSelfFilling\SelfFilling;

/**
 * @description Данные об экземляре приложения
 */
final class Application
{
    use SelfFilling;

    /**
     * @description Идентификатор экземпляра приложения, в котором пользователь общается с Марусей (максимум 64 символа).
     * Уникален в разрезе: скилл + приложение (устройство).
     */
    public readonly string $applicationId;

    /**
     * @description Тип приложения (устройства).
     * Возможные варинты: mobile, speaker, VK, other.
     *
     * @warning Отладчик навыков возвращает "mail"
     */
    public readonly string $applicationType;

    /**
     * @throws BadRequest
     */
    public function __construct(array $data)
    {
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
