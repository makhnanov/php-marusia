<?php

namespace Makhnanov\PhpMarusia\Request;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Request\RequestProperty\Nlu;
use Makhnanov\PhpSelfFilling\SelfFillableConstruct;
use Makhnanov\PhpSelfFilling\SelfFilling;

/**
 * @description Данные, полученные от пользователя
 *
 * @method string getCommand()
 * @method string getOriginalUtterance()
 * @method string getType()
 * @method null|string getPayload()
 * @method Nlu getNlu()
 */
final class RequestProperty implements SelfFillableConstruct
{
    use SelfFilling;

    /**
     * @description Пользовательский текст, очищенный от не влияющих на смысл преложения слов.
     * В ходе преобразования текст, в частности, очищается от знаков препинания, удаляются обращения к Марусе,
     * а также слова по типу "пожалуйста", "слушай" и т.д, а числительные преобразуются в числа.
     * При завершении скилла по команде "стоп", "выход" и так далее в скилл будет передано "on_interrupt",
     * чтобы у скилла была возможность попрощаться с пользователем.
     *
     * @see Request::isEnd()
     */
    public readonly string $command;

    /**
     * @description Полный текст пользовательского запроса, максимум 1024 символа.
     */
    public readonly string $originalUtterance;

    /**
     * @description Тип ввода, обязательное свойство.
     * Возможные значения:
     * "SimpleUtterance" — голосовой ввод,
     * "ButtonPressed" — нажатие кнопки.
     */
    public readonly string $type;

    /**
     * @description JSON, полученный с нажатой кнопкой от обработчика скилла (в ответе на предыдущий запрос),
     * максимум 4096 байт. Передаётся, только если была нажата кнопка с payload.
     */
    public readonly ?string $payload;

    /**
     * @description Объект, содержащий слова и именованные сущности,
     * которые Маруся извлекла из запроса пользователя, в поле tokens (array) .
     * ToDo: проверить наличие этого свойства при нажатии кнопки
     */
    public readonly Nlu $nlu;

    /**
     * @throws BadRequest
     */
    public function __construct(array $data)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
