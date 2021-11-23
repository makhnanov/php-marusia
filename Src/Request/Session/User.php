<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request\Session;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use Makhnanov\PhpMarusia\Getter;
use stdClass;

/**
 * @description Данные о пользователе. Передаётся, только если пользователь
 *
 * @method string getUserId()
 */
final class User
{
    use ProbablyBadRequest, Getter;

    private string $userId;

    /**
     * @throws BadRequest
     */
    public function __construct(stdClass $data)
    {
        /** @noinspection PhpStrictTypeCheckingInspection */
        $this->userId = $data->user_id ?? $this->throwException('user_id');
    }
}
