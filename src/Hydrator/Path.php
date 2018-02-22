<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * Used to reach a value deeper into the normalized data.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Path implements HydratorInterface
{
    /**
     * Path parts.
     *
     * @Required
     * 
     * @var array<string>
     */
    public $parts;

    /**
     * Final value Hydrator.
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
        foreach ($this->parts as $key) {
            if (
                !is_array($data)
                || !array_key_exists($key, $data)
            ) {
                return;
            }

            $data = $data[$key];
        }

        return $this->hydrator->hydrate($data, $configuration);
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        $res = $this->hydrator->normalize($data, $configuration);

        foreach ($this->parts as $key) {
            $res = [$key => $res];
        }

        return $res;
    }
}