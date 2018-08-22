# console
PHP Console Application Framework


## usage
```php
$app = new FightTheIce\Console\Application('Console App', 'Version');

//lets resolve a helloworld command
$app->resolve('HelloWorld');

$app->run();
```