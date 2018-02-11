<?php

namespace Potogan\Populator\Hydrator;

use Traversable;
use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Collection implements HydratorInterface
{
    /**
     * Struct mapped properties.
     *
     * @Required
     *
     * @var Potogan\Populator\HydratorInterface
     */
    public $internal;

    /**
     * If true, the original keys will be preserved.
     *
     * @var boolean
     */
    public $preserveKeys = true;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        if (!is_array($data) && !$data instanceof Traversable) {
            return [];
        }

        $res = [];

        foreach ($data as $key => $value) {
            $value = $this->internal->hydrate($value, $configuration);

            if ($this->preserveKeys) {
                $res[$key] = $value;
            } else {
                $res[] = $value;
            }
        }

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        if (!is_array($data) && !$data instanceof Traversable) {
            return [];
        }

        $res = [];

        foreach ($data as $key => $value) {
            $value = $this->internal->normalize($value, $configuration);

            if ($this->preserveKeys) {
                $res[$key] = $value;
            } else {
                $res[] = $value;
            }
        }

        return $res;
    }
}