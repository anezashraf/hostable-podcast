<?php

namespace App\Composer;

use Symfony\Component\Filesystem\Filesystem;

class Installation
{
    public static function install()
    {
        $filesystem = new Filesystem();

        putenv("mode=installation");
        $commands = [
            '%s/../../bin/console doctrine:database:create --env=prod',
            '%s/../../bin/console doctrine:schema:update --env=prod --force',
            '%s/../../bin/console doctrine:fixtures:load --no-interaction --env=prod',
        ];

        $dataLocation = sprintf("%s/../../var/data.db", __DIR__);


        if (! $filesystem->exists($dataLocation)) {
            foreach ($commands as $command) {
                passthru(sprintf(
                    $command,
                    __DIR__
                ));
            }
        }
    }
}
