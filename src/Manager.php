<?php

namespace Potogan\Populator;

use ReflectionClass;
use Doctrine\Common\Annotations\Reader;
use Potogan\Populator\Hydrator\Named;

class Manager
{
    /**
     * Annotation reader.
     * 
     * @var Reader
     */
    protected $reader;

    /**
     * Class constructor.
     *
     * @param Reader $reader Annotation reader.
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Hydrate $data using a class annotations.
     *
     * @param object|string      $class         Annotated classname/object.
     * @param mixed              $data          Input data.
     * @param Configuration|null $configuration Runtime configuration.
     * @param string|null        $name          Hydrator name to match.
     *
     * @return mixed
     */
    public function hydrate($class, $data, Configuration $configuration = null, $name = null)
    {
        $configuration = $configuration ?: new Configuration();
        $annotations = $this->reader->getClassAnnotations(new ReflectionClass($class));


        foreach ($annotations as $annotation) {
            if (
                !$annotation instanceof HydratorInterface
            ) {
                continue;
            }

            if (
                $name !== null
                && (!$annotation instanceof Named || $annotation->name !== $name)
            ) {
                continue;
            }

            return $annotation->hydrate($data, $configuration);
        }

        return $data;
    }
}
