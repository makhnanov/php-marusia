<?php

require_once __DIR__ . '/vendor/autoload.php';

use Makhnanov\PhpMarusia\MarusiaTools as Tools;
use Makhnanov\PhpMarusia\MarusiaRequest as Request;

Tools::setResponseHeaderAllowCors();

Request::handle()->response('qwerty')->answer();
