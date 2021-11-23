<?php

namespace App\Listener;

use App\Event\CharacterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            CharacterEvent::CHARACTER_CREATED => 'characterCreated',
        );
    }

    public function characterCreated($event)
    {
        $character = $event->getCharacter();
        $character->setIntelligence(250);
    }
}
