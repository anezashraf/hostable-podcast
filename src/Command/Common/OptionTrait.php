<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 23/04/19
 * Time: 18:58
 */

namespace App\Command\Common;


use App\Entity\Contracts\Updatable;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

trait OptionTrait
{
    public function getDefinitionFromEntity(Updatable $updatable)
    {
        return new InputDefinition(array_map(function(string $property) {
            return new InputOption($property, null, InputOption::VALUE_OPTIONAL);
        }, $updatable->updatableProperties()));

    }

}
