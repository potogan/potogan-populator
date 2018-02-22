<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * Transparent Hydrator wrapper holding a name.
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class Named implements HydratorInterface
{
    /**
     * Hydrator name
     *
     * @Required
     * 
     * @var string
     */
    public $name;

    /**
     * Wapped Hydrator.
     *
     * @Required
     *
     * @var Potogan\Populator\HydratorInterface
     */
    public $wrapped;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        return $this->wrapped->hydrate($data, $configuration);
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        return $this->wrapped->normalize($data, $configuration);
    }
}