<?php

use HaydenPierce\ClassFinder\ClassFinder;
use Psr\Container\ContainerInterface;

return [
    'app.name' => 'M2-Cli',
    'app.version' => 'v0.0.1',
    'commands' => array_map(function (string $class) {
        return \DI\get($class);
    }, ClassFinder::getClassesInNamespace('App\Command')),
    \Ahc\Cli\Application::class => function (ContainerInterface $c) {
        return new \Ahc\Cli\Application($c->get('app.name'), $c->get('app.version'));
    },
];
