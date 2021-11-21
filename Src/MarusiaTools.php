<?php

namespace Makhnanov\PhpMarusia;

class MarusiaTools
{
    public static function setResponseHeaderAllowCors()
    {
        header('Access-Control-Allow-Origin: https://skill-debugger.marusia.mail.ru');
        header('Access-Control-Allow-Headers: Content-Type');
    }

    public static function getOutputBuffer(mixed $var): string
    {
        ob_start();
        var_dump($var);
        return ob_get_clean() ?: 'Output buffering is not active.';
    }
}
