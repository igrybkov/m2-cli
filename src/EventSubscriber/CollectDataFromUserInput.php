<?php

namespace App\EventSubscriber;

use App\CommandConfigurator\ConfiguratorComposite;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollectDataFromUserInput implements EventSubscriberInterface
{
    /**
     * @var ConfiguratorComposite
     */
    private $configuratorComposite;

    public function __construct(ConfiguratorComposite $configuratorComposite)
    {
        $this->configuratorComposite = $configuratorComposite;
    }

    /**
     * @return array<string, array<int, array<int,int|string>>>
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => [
                ['collect', 10]
            ]
        ];
    }

    public function collect(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();
        if ($command) {
            $this->configuratorComposite->collectUserInput($event->getInput(), $event->getOutput(), $command, $event);
        }
    }
}
