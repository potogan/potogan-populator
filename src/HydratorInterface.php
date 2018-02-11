<?php

namespace Potogan\HotoilBundle\Hydratation;

interface HydratorInterface
{
    /**
     * Hydrates input data.
     *
     * @param mixed         $data          Normalized data to hydrate into something else.
     * @param Configuration $configuration Runtime configuration.
     * 
     * @return mixed
     */
    public function hydrate($data, Configuration $configuration);
}