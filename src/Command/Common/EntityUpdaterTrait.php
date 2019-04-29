<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 23/04/19
 * Time: 18:58
 */

namespace App\Command\Common;

use App\Entity\Contracts\Updatable;
use App\File\FileParserFactory;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait EntityUpdaterTrait
{
    public function updateEntity(Updatable $updatable, InputInterface $input, $blacklist = []) : Updatable
    {
        foreach ($updatable->updatableProperties() as $property) {
            if ($input->getOption($property)) {
                $value = $input->getOption($property);

                if (in_array($property, $blacklist)) {
                    $enclosureParser = FileParserFactory::create($input->getOption($property), $property);
                    if ($enclosureParser->isValid()) {
                        $value = $enclosureParser->getFormattedEnclosure();
                    }
                }

                $methodName = 'set' . ucfirst($property);
                $updatable->$methodName($value);
            }
        }

        return $updatable;
    }
}
