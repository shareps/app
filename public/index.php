<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__) . '/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

$trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false;
$trustedProxies = $trustedProxies ? explode(',', $trustedProxies) : [];
$trustedHeadersSet = Request::HEADER_X_FORWARDED_ALL;

if ('prod' === $_SERVER['APP_ENV'] && ('HEROKU' === $_SERVER['ENVIRONMENT_TYPE'] || 'HEROKU' === $_ENV['ENVIRONMENT_TYPE'])) {
    $trustedProxies[] = $_SERVER['REMOTE_ADDR'];
    $trustedHeadersSet = Request::HEADER_X_FORWARDED_AWS_ELB;
}

if ($trustedProxies) {
    Request::setTrustedProxies($trustedProxies, $trustedHeadersSet);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
