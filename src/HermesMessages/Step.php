<?php

namespace Eduzz\Goofy\HermesMessages;

use Eduzz\Hermes\Message\AbstractMessage;

class Step extends AbstractMessage
{
    /**
     * Constructor
     *
     * @param string $application
     * @param string $flow
     * @param string $trackerId
     * @param string $step
     * @param string $data
     */
    public function __construct(
        $application,
        $flow,
        $trackerId,
        $step,
        $data
    ) {
        $payload = (object) array(
            "tracker_id" => $trackerId,
            "application" => $application,
            "flow" => $flow,
            "data" => $data,
            "step" => (object)array(
                "name" => $step,
                "date" => $this->getGMTDate()
            )
        );

        parent::__construct("goofy.track.$application", $payload);
    }

    /**
     * Return actual date in GMT format
     *
     * @return string
     */
    private function getGMTDate()
    {
        $time = gmdate('Y-m-d\tH:i:s');
        $ms = round(explode('.', microtime(true))[1] / 10, 0);
        $ms = str_pad($ms, 3, '0');

        return "{$time}.{$ms}Z";
    }
}
