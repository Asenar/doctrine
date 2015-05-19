<?php

namespace Kohana\Doctrine;

use Doctrine\Common\EventManager as DoctrineEventManager;
use Kohana;

class EventManager
{
    public function instance($settings = null)
    {
        if(is_null($settings)) {
            $settings = $this->getSettings();
        }

        $eventManager = new DoctrineEventManager;

        $eventsConfig = $settings['events'];

        foreach($eventsConfig['listeners'] AS $listener => $events) {
            $eventManager->addEventListener((array) $events, new $listener());
        }

        foreach($eventsConfig['subscribers'] AS $subscriber) {
            $eventManager->addEventSubscriber(new $subscriber());
        }

        return $eventManager;
    }

    /**
     * Get settings from configuration file
     *
     * @static
     * @access private
     * @return object
     */
    private function getSettings()
    {
        return Kohana::$config->load('doctrine');
    }
} 
