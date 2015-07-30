<?php

namespace Kohana\Doctrine;

use Doctrine\Common\EventManager as DoctrineEventManager;

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

    /**
     * @param Configuration $configuration
     * @param DoctrineEventManager $eventManager
     */
    public function __construct(Configuration $configuration, DoctrineEventManager $eventManager)
    {
        $this->configuration = $configuration;
        $this->eventManager = $eventManager;
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
