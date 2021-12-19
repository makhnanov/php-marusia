<?php

declare(strict_types=1);

use Makhnanov\PhpMarusia\Exception\BadResponse;
use Makhnanov\PhpMarusia\Exception\InvalidAuthId;
use Makhnanov\PhpMarusia\Request;
use Makhnanov\PhpMarusia\Response;
use Makhnanov\PhpMarusia\Tools;
use Makhnanov\PhpMarusia\Exception\BadRequest;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    Tools::setResponseHeaderAllowCors();

    $request = Request::handle(
        Tools::receiveData() ?: throw new BadRequest('Data is empty.'),
        null,
        false
    );

    Response::create()
        ->setRequest($request)
        ->setText('Маруся передаёт привет.')
        ->say();

} catch (BadRequest) {
    // Do nothing or log trying
} catch (BadResponse) {
    // Programmer error, notify lead
} catch (InvalidAuthId) {
    // Cracker detected
    echo json_encode([
        'result' => false,
        'reason' => 'Available only for VK',
    ]);
} catch (Throwable $e) {
    // Something went wrong
    echo json_encode([
        'result' => false,
        'reason' => $e->getMessage(),
    ]);
}
