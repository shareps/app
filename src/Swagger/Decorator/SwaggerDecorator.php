<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Swagger\Decorator;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param mixed  $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     *
     * @return array|string|int|float|bool
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var array $docs */
        $docs = $this->decorated->normalize($object, $format, $context);
        if (\is_array($docs)) {
            $docs['info']['title'] = 'Shared Resources API';
        }

        return $docs;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
