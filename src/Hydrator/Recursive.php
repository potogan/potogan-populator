<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * Recursive hydrator : will use manager to find a named hydrator for the target
 * class name.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Recursive implements HydratorInterface
{
    /**
     * Object class name.
     *
     * @Required
     * 
     * @var string
     */
    public $class;

    /**
     * Hydrator name.
     * 
     * @var string
     */
    public $name;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        return $configuration->get('manager')->hydrate($this->class, $data, $configuration, $this->name);
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        var_dump($this->class);
        var_dump($this->name);
        return $configuration->get('manager')->normalize($this->class, $data, $configuration, $this->name);
    }
}
