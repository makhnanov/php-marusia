<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request;

use Makhnanov\PhpMarusia\Request;
use Makhnanov\PhpMarusia\Request\Session\Application;
use Makhnanov\PhpMarusia\Request\Session\User;
use Makhnanov\PhpSelfFilling\SelfFillable;
use Makhnanov\PhpSelfFilling\SelfFillableConstruct;
use Makhnanov\PhpSelfFilling\SelfFilling;
use stdClass;

/**
 * @description Данные о сессии.
 */
final class Session implements SelfFillableConstruct
{
    use SelfFilling;

    /**
     * @description Уникальный идентификатор сессии, максимум 64 символа
     */
    public readonly string $sessionId;

    /**
     * @description Идентификатор экземпляра приложения, в котором пользователь общается с Марусей, максимум 64 символа.
     * @deprecated Важно! Это поле устарело, вместо него стоит использовать session.application.application_id
     * @see Application::getApplicationId()
     */
    public readonly ?string $userId;

    /**
     * @description Идентификатор вызываемого скилла, присвоенный при создании.
     * Соответствует полю "Маруся ID" в настройках скилла.
     */
    public readonly string $skillId;

    /**
     * @description Признак новой сессии:
     * true — пользователь начинает новый разговор с вызова навыка,
     * false — запрос отправлен в рамках уже начатого разговора.
     *
     * @see Request::isStart()
     */
    public readonly bool $new;

    /**
     * @description Идентификатор сообщения в рамках сессии, максимум 8 символов.
     * Инкрементируется с каждым следующим запросом.
     */
    public readonly int $messageId;

    /**
     * @description Данные о пользователе.
     * Передаётся, только если пользователь авторизован.
     */
    public readonly ?User $user;

    /**
     * @description Данные об экземляре приложения
     */
    public readonly Application $application;

    /**
     * @description Авторизационный токен Маруси.
     */
    public readonly string $authToken;

    public function __construct(stdClass $data)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
