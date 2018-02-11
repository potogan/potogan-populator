<?php

namespace Potogan\HotoilBundle\Hydratation\Hydrator;

use Potogan\HotoilBundle\Hydratation\Configuration;
use Potogan\HotoilBundle\Hydratation\HydratorInterface;

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
     * @var Potogan\HotoilBundle\Hydratation\HydratorInterface
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