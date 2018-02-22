<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * Transparent Hydrator wrapper. It's purpose is to tell the Struct Hydrator to give the data it
 *     received instead of only the property corresponding part, a bit like inherit_data in Symfony
 *     forms.
 *
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class InheritData implements HydratorInterface
{
    /**
     * Wrapped Hydrator.
     *
     * @Required
     *
     * @var Potogan\Populator\HydratorInterface
     */
    public $hydrator;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        return $this->hydrator->hydrate($data, $configuration);
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        return $this->hydrator->normalize($data, $configuration);
    }
}