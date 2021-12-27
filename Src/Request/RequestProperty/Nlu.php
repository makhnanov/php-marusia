<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request\RequestProperty;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpSelfFilling\SelfFilling;

/**
 * @description Объект, содержащий слова и именованные сущности,
 * которые Маруся извлекла из запроса пользователя, в поле tokens (array) .
 */
final class Nlu
{
    use SelfFilling;

    /**
     * @description Объект, содержащий слова и именованные сущности,
     * которые Маруся извлекла из запроса пользователя, в поле tokens (array) .
     */
    protected array $tokens;

    /**
     * @warning
     * @description В официальной документации этого нет
     * ToDo: examples
     */
    protected ?array $entities;

    /**
     * @throws BadRequest
     */
    public function __construct(array $data)
    {
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
