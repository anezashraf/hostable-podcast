<?php

$commands = [
    '%s/../../bin/console doctrine:schema:update -vvv --env=test --force',
    '%s/../../bin/console doctrine:fixtures:load -vvv --no-interaction --env=test',
];

foreach ($commands as $command) {
    passthru(sprintf(
        $command,
        __DIR__
    ));
}

require __DIR__ . '/../../vendor/autoload.php';
