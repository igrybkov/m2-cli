<?php

require_once __DIR__ . '/../vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/config.php');

/** @var \DI\Container $container */
$container = $builder->build();
return $container;