<?php

$commands = [
    '%s/../../bin/console doctrine:database:drop --force --env=test',
    '%s/../../bin/console doctrine:database:create --env=test',
    '%s/../../bin/console doctrine:schema:update --env=test --force',
    '%s/../../bin/console doctrine:fixtures:load --no-interaction --env=test',
];

foreach ($commands as $command) {
    passthru(sprintf(
        $command,
        __DIR__
    ));
}

require __DIR__ . '/../../vendor/autoload.php';
