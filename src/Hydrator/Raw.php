<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

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
}