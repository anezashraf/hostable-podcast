<?php

namespace App\Tests\Resources;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestListenerTest;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use Symfony\Component\Filesystem\Filesystem;

class PublicDirListener implements TestListener
{

    use TestListenerDefaultImplementation;

    /**
     * A test suite started.
     *
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite)
    {
        if (in_array('public_resources', $suite->getGroups())) {
            $filesystem = new Filesystem();

            $filesystem->mirror(__DIR__ . '/audio', __DIR__. '/../../public/audio');
            $filesystem->mirror(__DIR__ . '/images', __DIR__. '/../../public/images');
        }
    }

    /**
     * A test suite ended.
     *
     * @param TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite)
    {
        if (in_array('public_resources', $suite->getGroups())) {
            $filesystem = new Filesystem();

            $filesystem->remove(__DIR__. '/../../public/audio');
            $filesystem->remove(__DIR__. '/../../public/images');
        }
    }
}
