<?php

namespace Potogan\HotoilBundle\Hydratation\Hydrator;

use Potogan\HotoilBundle\Hydratation\Configuration;
use Potogan\HotoilBundle\Hydratation\HydratorInterface;

/**
 * Transparent Hydrator, used to transmit a value without any modification.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Raw implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        return $data;
    }
}