<?php

namespace Makhnanov\PhpMarusia\Request;

use Makhnanov\PhpMarusia\Exception\BadRequest;
use Makhnanov\PhpMarusia\Exception\ProbablyBadRequest;
use stdClass;

/**
 * @description Информация об устройстве, с помощью которого пользователь общается с Марусей.
 *
 * @method null|string getClient()
 * @method string getLocale()
 * @method string getTimezone()
 * @method array getInterfaces()
 * @method null|string getCityRu()
 */
class Meta
{
    use ProbablyBadRequest;

    /**
     * @warning
     * @description В официальной докуентации этого нет
     * При получении ответа от отладчика это свойство имеет значение "MailRu-VC/1.0"
     */
    protected ?string $clientId;

    /**
     * @description Язык в POSIX-формате, максимум 64 символа.
     */
    protected string $locale;

    /**
     * @description Название часового пояса, включая алиасы, максимум 64 символа
     */
    protected string $timezone;

    /**
     * @description Интерфейсы, доступные на устройстве пользователя,
     * сейчас всегда присылается screen — пользователь может видеть ответ скилла на экране
     * и открывать ссылки в браузере.
     */
    protected array $interfaces;

    /**
     * @warning
     * @description В официальной докуентации этого нет
     * При получении ответа от отладчика это свойство имеет значение "Томск'
     * По всей видимости это город текущего местонахождения пользователя на русском
     */
    protected ?string $cityRu;

    /**
     * @throws BadRequest
     */
    public function __construct(stdClass $data)
    {
        $this->clientId = $data->client_id ?? null;
        $this->locale = $data->locale ?? $this->throwException('locale');
        $this->timezone = $data->timezone ?? $this->throwException('timezone');
        $this->interfaces = $data->interfaces ?? $this->throwException('interfaces');
        $this->cityRu = $data->_city_ru ?? null;
    }
}
