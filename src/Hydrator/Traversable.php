<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Traversable implements HydratorInterface
{
    /**
     * Wapped Hydrator.
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
        $res = [];

        foreach ($data as $key => $value) {
            $res[$key] = $this->hydrator->hydrate($value, $configuration);
        }

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        $res = [];
        
        foreach ($data as $key => $value) {
            $res[$key] = $this->hydrator->normalize($value, $configuration);
        }

        return $res;
    }
}
