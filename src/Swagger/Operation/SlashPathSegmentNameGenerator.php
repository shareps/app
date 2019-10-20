<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Swagger\Operation;

use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;
use Doctrine\Common\Inflector\Inflector;

final class SlashPathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSegmentName(string $name, bool $collection = true): string
    {
        $name = $this->slashize($name);

        return $collection ? Inflector::pluralize($name) : $name;
    }

    private function slashize(string $string): string
    {
        $string = preg_replace('~(?<=\\w)([A-Z])~', '/$1', $string);

        return strtolower($string);
    }
}
