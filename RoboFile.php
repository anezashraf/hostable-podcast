<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function analyse()
    {
        $this->phpunit();
        $this->phpmd();
        $this->phpcs();
        $this->phpmd();
    }

    public function phpunit()
    {
        $this->lint([
            'command' => './bin/phpunit'
        ]);
    }

    public function phpcs()
    {
        $this->lint([
            'command' => './vendor/bin/phpcs'
        ]);
    }

    public function phpmd()
    {
        $this->lint([
            'command' => './vendor/bin/phpmd src text ruleset.xml'
        ]);
    }

    public function phpstan()
    {
        $this->lint([
            'command' => './vendor/bin/phpstan analyse -l 7 -c extension.neon src tests'
        ]);
    }

    private function lint($options)
    {
        $this->taskExec($options['command'])->run();
    }
}
