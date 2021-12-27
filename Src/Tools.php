<?php /** @noinspection SpellCheckingInspection */

declare(strict_types=1);

namespace Makhnanov\PhpMarusia;

class Tools
{
    public static function setResponseHeaderAllowCors()
    {
        header('Access-Control-Allow-Origin: https://skill-debugger.marusia.mail.ru');
        header('Access-Control-Allow-Headers: Content-Type');
    }

    public static function receiveData(): string|false
    {
        return file_get_contents('php://input');
    }
}
