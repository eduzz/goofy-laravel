<?php

namespace Eduzz\Goofy;

use Eduzz\Hermes\Hermes;
use Eduzz\Goofy\HermesMessages\Step;

class Goofy
{
    private $hermes;
    private $application;
    private $enabled = true;

    public function __construct($application, Hermes $hermes)
    {
        $this->application = $application;
        $this->hermes = $hermes;
        $this->enabled = $this->isValidUserAgent();
    }

    public function publish(
        $trackerId,
        $flow,
        $step,
        array $extraData = []
    ) {

        if (!$this->enabled) {
            return;
        }

        $extraData = (object) $extraData;

        $message = new Step(
            $this->application,
            $flow,
            $trackerId,
            $step,
            $extraData
        );

        $this->hermes->publish($message);
    }

    public function isValidUserAgent()
    {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        $invalidUserAgents = [
            "googlebot", 
            "mediapartners-google",
            "adsbot-google",
            "yandexbot",
            "yandexmobilebot",
            "bingbot",
            "slurp",
            "duckduckbot",
            "baiduspider",
            "sogou",
            "exabot",
            "facebookexternalhit",
            "facebot",
            "ia_archiver",
            "linkdexbot",
            "gigabot",
            "catchbot",
            "ccbot"
        ];

        $agentList = implode('|', $invalidUserAgents);
        return !preg_match("@($agentList)@", strtolower($userAgent));
    }
}
