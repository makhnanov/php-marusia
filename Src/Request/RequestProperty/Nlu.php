<?php

declare(strict_types=1);

namespace Makhnanov\PhpMarusia\Request\RequestProperty;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use Makhnanov\PhpMarusia\Getter;
use stdClass;

/**
 * @description Объект, содержащий слова и именованные сущности,
 * которые Маруся извлекла из запроса пользователя, в поле tokens (array) .
 *
 * @method array getTokens()
 * @method array getEntities()
 */
class Nlu
{
    use ProbablyBadRequest, Getter;

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
    public function __construct(stdClass $data)
    {
        $this->tokens = $data->tokens ?? $this->throwException('tokens');
        $this->entities = $data->entities ?? null;
    }
}
