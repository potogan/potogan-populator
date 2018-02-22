<?php

namespace Potogan\Populator\Hydrator;

use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Struct implements HydratorInterface
{
    /**
     * Struct mapped properties.
     *
     * @Required
     *
     * @var array<Potogan\Populator\HydratorInterface>
     */
    public $properties;

    /**
     * If true, every input data will be kept, and eventually erased by mapped properties.
     *
     * @var boolean
     */
    public $keepNonMapped = false;

    /**
     * If true, hydrated value will be a stdclass object instead of an array
     *
     * @var boolean
     */
    public $asObject = false;

    /**
     * Field aliases mapping (normalizedName => hydratedName)
     *
     * @var array<string>
     */
    public $aliases = array();

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        $res = $this->keepNonMapped ? $data : [];

        // Can't hydrate from a non-array
        if (!is_array($data)) {
            return $this->asObject ? (object)$res : $res;
        }

        foreach ($this->properties as $normalizedName => $hydrator) {
            $hydratedName = isset($this->aliases[$normalizedName]) 
                ? $this->aliases[$normalizedName]
                : $normalizedName
            ;
            $res[$hydratedName] = null;

            if (!array_key_exists($normalizedName, $data)) {
                continue;
            }

            $res[$hydratedName] = $hydrator->hydrate(
                $hydrator instanceof InheritData ? $data : $data[$normalizedName],
                $configuration
            );
        }

        return $this->asObject ? (object)$res : $res;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        if (is_object($data) && $this->asObject) {
            $data = get_object_vars($data);
        }

        if (!is_array($data)) {
            return [];
        }

        $res = $this->keepNonMapped ? $data : [];

        foreach ($this->properties as $normalizedName => $hydrator) {
            $hydratedName = isset($this->aliases[$normalizedName]) 
                ? $this->aliases[$normalizedName]
                : $normalizedName
            ;

            $normalized = null;
            if (array_key_exists($hydratedName, $data)) {
                $normalized = $hydrator->normalize(
                    $data[$hydratedName],
                    $configuration
                );
            }

            if ($hydrator instanceof InheritData) {
                $res = array_merge($res, $normalized);
            } else {
                $res[$normalizedName] = $normalized;
            }
        }

        return $res;
    }
}
