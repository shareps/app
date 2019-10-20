<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message;

trait MessageJsonSerializeTrait
{
    public function jsonSerialize(): array
    {
        $properties = get_object_vars($this);

        return $this->jsonSerializeArray($properties);
    }

    private function jsonSerializeArray(array $properties): array
    {
        $jsonData = [];
        foreach ($properties as $name => $value) {
            if (\is_string($name)) {
                $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
            }
            if ($value instanceof \JsonSerializable) {
                $jsonData[$name] = $value->jsonSerialize();
            } elseif (\is_array($value) && \count($value) > 0) {
                $jsonData[$name] = $this->jsonSerializeArray($value);
            } elseif (\is_bool($value)) {
                $jsonData[$name] = $value;
            } elseif (!empty($value)) {
                $jsonData[$name] = $value;
            }
        }

        return $jsonData;
    }
}
