<?php

include '../vendor/autoload.php';

/**
 * for testing lets just load all of the commands folder
 */
foreach (glob('commands/*.php') as $file) {
    include $file;
}

$app = new FightTheIce\Console\Application('Console App', 'Beta-1');
$app->getEvents()->listen(FightTheIce\Console\Events\BeforeCommand::class, function ($event) {
    echo 'Running this before Command: ' . $event->getCommand()->getName() . PHP_EOL;
});
$app->getEvents()->listen(FightTheIce\Console\Events\AfterCommand::class, function ($event) {
    echo 'Running this after Command: ' . $event->getCommand()->getName() . PHP_EOL;
});
$app->resolve('Hello');
$app->resolve('Say');

$app->run();
