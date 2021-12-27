<?php

namespace Makhnanov\PhpMarusia\Request;

use Makhnanov\PhpSelfFilling\SelfFilling;

/**
 * @description Информация об устройстве, с помощью которого пользователь общается с Марусей.
 */
final class Meta
{
    use SelfFilling;

    /**
     * @warning
     * @description В официальной докуентации этого нет
     * При получении ответа от отладчика это свойство имеет значение "MailRu-VC/1.0"
     */
    public readonly ?string $clientId;

    /**
     * @description Язык в POSIX-формате, максимум 64 символа.
     */
    public readonly string $locale;

    /**
     * @description Название часового пояса, включая алиасы, максимум 64 символа
     */
    public readonly string $timezone;

    /**
     * @description Интерфейсы, доступные на устройстве пользователя,
     * сейчас всегда присылается screen — пользователь может видеть ответ скилла на экране
     * и открывать ссылки в браузере.
     */
    public readonly array $interfaces;

    /**
     * @warning
     * @description В официальной докуентации этого нет
     * При получении ответа от отладчика это свойство имеет значение "Томск'
     * По всей видимости это город текущего местонахождения пользователя на русском
     */
    public readonly ?string $cityRu;

    public function __construct(array $data)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->selfFill($data, fromDataIdToPropertyCamel: true);
    }
}
