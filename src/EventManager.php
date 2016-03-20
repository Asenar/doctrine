<?php

namespace Kohana\Doctrine;

use Doctrine\Common\EventManager as DoctrineEventManager;
use Kohana;

class EventManager
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var DoctrineEventManager
     */
    private $eventManager;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->eventManager = new DoctrineEventManager;
    }

    /**
     * @return DoctrineEventManager
     */
    public function configureEventManager()
    {
        $eventConfiguration = $this->configuration->get('event');

        foreach ($eventConfiguration['listeners'] as $listener => $events) {
            $this->eventManager->addEventListener((array) $events, new $listener());
        }

        foreach ($eventConfiguration['subscribers'] as $subscriber) {
            $this->eventManager->addEventSubscriber(new $subscriber());
        }

        return $this->eventManager;
    }
} 
