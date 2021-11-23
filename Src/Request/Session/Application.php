<?php

namespace Makhnanov\PhpMarusia\Request\Session;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use Makhnanov\PhpMarusia\Getter;
use stdClass;

/**
 * @description Данные об экземляре приложения
 *
 * @method string getApplicationId()
 * @method string getApplicationType()
 */
class Application
{
    use ProbablyBadRequest, Getter;

    /**
     * @description Идентификатор экземпляра приложения, в котором пользователь общается с Марусей (максимум 64 символа).
     * Уникален в разрезе: скилл + приложение (устройство).
     */
    private string $applicationId;

    /**
     * @description Тип приложения (устройства).
     * Возможные варинты: mobile, speaker, VK, other.
     *
     * @warning Отладчик навыков возвращает "mail"
     */
    private string $applicationType;

    /**
     * @throws BadRequest
     */
    public function __construct(stdClass $data)
    {
        $this->applicationId = $data->application_id ?? $this->throwException('application_id');
        $this->applicationType = $data->application_type ?? $this->throwException('application_type');
    }
}
