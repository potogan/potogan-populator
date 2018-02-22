<?php

namespace Potogan\Populator\Hydrator;

use ReflectionClass;
use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class Object implements HydratorInterface
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
     * Struct mapped properties.
     *
     * @Required
     *
     * @var Potogan\Populator\Hydrator\Struct
     */
    public $properties;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        $this->properties->asObject = false;

        $class = new ReflectionClass($this->class);

        $res = $class->newInstanceWithoutConstructor();

        $fields = $this->properties->hydrate($data, $configuration);

        foreach ($fields as $name => $value) {
            if (!$class->hasProperty($name)) {
                continue;
            }

            $property = $class->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($res, $value);
        }

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        $class = new ReflectionClass($this->class);

        foreach ($class->getProperties() as $property) {
            $property->setAccessible(true);

            $res[$property->getName()] = $property->getValue($data);
        }

        return $this->properties->normalize($res, $configuration);
    }
}
