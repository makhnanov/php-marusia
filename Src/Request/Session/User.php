<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request\Session;

use Makhnanov\PhpSelfFilling\SelfFillableConstruct;
use Makhnanov\PhpSelfFilling\SelfFilling;

/**
 * @description Данные о пользователе. Передаётся, только если пользователь
 *
 * @method string getUserId()
 */
final class User implements SelfFillableConstruct
{
    use SelfFilling;

    public readonly string $userId;

    public function __construct(array $data)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
