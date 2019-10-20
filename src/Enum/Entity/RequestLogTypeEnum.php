<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Enum\Entity;

use MyCLabs\Enum\Enum;

/**
 * @method static RequestLogTypeEnum COMMAND()
 * @method static RequestLogTypeEnum HTTP()
 * @method static RequestLogTypeEnum API()
 * @method static RequestLogTypeEnum SLACK()
 */
class RequestLogTypeEnum extends Enum
{
    public const COMMAND = 'COMMAND';
    public const HTTP = 'HTTP';
    public const API = 'API';
    public const SLACK = 'SLACK';
}
