<?php

namespace Potogan\Populator\Hydrator;

use DateTimeZone;
use DateTimeImmutable;
use Potogan\Populator\Configuration;
use Potogan\Populator\HydratorInterface;

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
        $format = $this->format ?: $configuration->get('datetime_default_format', 'Y-m-d H:i:s');
        $internalTimezone = $configuration->get(
            'datetime_application_timezone',
            new DateTimeZone(date_default_timezone_get())
        );

        $timezone = $configuration->get('datetime_data_timezone', $internalTimezone);

        $date = DateTimeImmutable::createFromFormat($format, $data, $timezone);

        if ($timezone !== $internalTimezone) {
            $date = $date->setTimezone($internalTimezone);
        }

        return $date;
    }
}