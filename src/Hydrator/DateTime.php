<?php

namespace Potogan\HotoilBundle\Hydratation\Hydrator;

use DateTimeZone;
use DateTimeInterface;
use DateTimeImmutable;
use Potogan\HotoilBundle\Hydratation\Configuration;
use Potogan\HotoilBundle\Hydratation\HydratorInterface;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 *
 * Configuration options : 
 *  - datetime_default_format : Fallback date format
 *  - datetime_data_timezone  : Input data timezone
 *  - datetime_application_timezone : Application timezone
 */
class DateTime implements HydratorInterface
{
    /**
     * DateTime format. If null, will fallback to the default format given by configuration.
     *
     * @var string
     */
    public $format;

    /**
     * @inheritDoc
     */
    public function hydrate($data, Configuration $configuration)
    {
        $c = $this->buildConfiguration($configuration);

        $date = DateTimeImmutable::createFromFormat($c->get('format'), $data, $c->get('timezone'));

        if ($c->get('timezone') !== $c->get('internal_timezone')) {
            $date = $date->setTimezone($c->get('internal_timezone'));
        }

        return $date;
    }

    /**
     * @inheritDoc
     */
    public function normalize($data, Configuration $configuration)
    {
        if (!$data instanceof DateTimeInterface) {
            return;
        }

        if (!$data instanceof DateTimeImmutable) {
            $data = clone $data;
        }

        $c = $this->buildConfiguration($configuration);


        if ($c->get('timezone') !== $c->get('internal_timezone')) {
            $date = $date->setTimezone($c->get('timezone'));
        }

        return $date->format($c->get('format'));
    }

    protected function buildConfiguration($configuration)
    {
        $format = $this->format ?: $configuration->get('datetime_default_format', 'Y-m-d H:i:s');
        $internalTimezone = $configuration->get(
            'datetime_application_timezone',
            new DateTimeZone(date_default_timezone_get())
        );

        $timezone = $configuration->get('datetime_data_timezone', $internalTimezone);

        return new Configuration([
            'format' =>$this->format ?: $configuration->get('datetime_default_format', 'Y-m-d H:i:s'),
            'internal_timezone' => $internalTimezone,
            'timezone' => $timezone,
        ]);
    }
}