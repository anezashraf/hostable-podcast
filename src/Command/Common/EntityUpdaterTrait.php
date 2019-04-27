<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 23/04/19
 * Time: 18:58
 */

namespace App\Command\Common;

use App\Entity\Contracts\Updatable;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait EntityUpdaterTrait
{
    public function updateEntity(Updatable $updatable, InputInterface $input) : Updatable
    {
        foreach ($updatable->updatableProperties() as $property) {
            if ($input->getOption($property)) {
                $methodName = 'set' . ucfirst($property);
                $updatable->$methodName($input->getOption($property));
            }
        }

        return $updatable;
    }
}
