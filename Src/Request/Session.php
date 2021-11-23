<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use Makhnanov\PhpMarusia\Getter;
use Makhnanov\PhpMarusia\Request;
use Makhnanov\PhpMarusia\Request\Session\Application;
use Makhnanov\PhpMarusia\Request\Session\User;
use stdClass;

/**
 * @description Данные о сессии.
 *
 * @method string getSessionId()
 * @method string getSkillId()
 * @method bool getNew()
 * @method int getMessageId()
 * @method null|User getUser()
 * @method Application getApplication()
 * @method string getAuthToken()
 */
final class Session
{
    use ProbablyBadRequest, Getter;

    /**
     * @description Уникальный идентификатор сессии, максимум 64 символа
     */
    private string $sessionId;

    /**
     * @description Идентификатор экземпляра приложения, в котором пользователь общается с Марусей, максимум 64 символа.
     * @deprecated Важно! Это поле устарело, вместо него стоит использовать session.application.application_id
     * @see Application::getApplicationId()
     */
    private ?string $userId;

    /**
     * @description Идентификатор вызываемого скилла, присвоенный при создании.
     * Соответствует полю "Маруся ID" в настройках скилла.
     */
    private string $skillId;

    /**
     * @description Признак новой сессии:
     * true — пользователь начинает новый разговор с вызова навыка,
     * false — запрос отправлен в рамках уже начатого разговора.
     *
     * @see Request::isStart()
     */
    private bool $new;

    /**
     * @description Идентификатор сообщения в рамках сессии, максимум 8 символов.
     * Инкрементируется с каждым следующим запросом.
     */
    private int $messageId;

    /**
     * @description Данные о пользователе.
     * Передаётся, только если пользователь авторизован.
     */
    private ?User $user;

    /**
     * @description Данные об экземляре приложения
     */
    private Application $application;

    /**
     * @description Авторизационный токен Маруси.
     */
    private string $authToken;

    /**
     * @noinspection PhpStrictTypeCheckingInspection
     * @throws BadRequest
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = $data->session_id ?? $this->throwException('session_id');
        $this->userId = $data->user_id ?? null;
        $this->skillId = $data->skill_id ?? $this->throwException('skill_id');
        $this->new = $data->new ?? $this->throwException('new');
        $this->messageId = $data->message_id ?? $this->throwException('message_id');
        $this->user = new User($data->user ?? $this->throwException('user'));
        $this->application = new Application($data->application ?? $this->throwException('application'));
        $this->authToken = $data->auth_token ?? $this->throwException('auth_token');
    }

    /**
     * @deprecated
     * @see Session::$userId
     */
    public function getUserId(): string|null
    {
        return $this->userId;
    }
}
