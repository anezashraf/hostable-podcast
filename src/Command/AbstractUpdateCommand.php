<?php

namespace App\Command;

use App\Command\Common\EntityUpdaterTrait;
use App\Command\Common\OptionTrait;
use App\Entity\Contracts\Updatable;
use App\Repository\Contracts\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractUpdateCommand extends Command
{
    use EntityUpdaterTrait;
    use OptionTrait;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(null);

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $def = new InputDefinition();

        if ($this->getArgument()) {
            $def->addArgument($this->getArgument());
        }

        $def->addOptions($this->getOptionsFromEntity($this->getEntity()));
        $this->setDefinition($def);
    }

    abstract public function getEntity();

    abstract public function getFileProperties();

    abstract public function getArgument() : ?InputArgument;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository(get_class($this->getEntity()));

        $value = 1;
        $row = [];
        $headers = $this->getEntity()->updatableProperties();

        if ($this->getArgument() !== null) {
            $value = $input->getArgument($this->getArgument()->getName());
            $row[] = $value;
            array_unshift($headers, $this->getArgument()->getName());
        }

        /** @var Updatable $entity */
        $entity = $repository->get($value);

        $entity = $this->updateEntity($entity, $input, $this->getFileProperties());

        $repository->saveOrUpdate($entity);

        $table = new Table($output);
        $table->setStyle("compact");

        foreach ($entity->updatableProperties() as $property) {
            $method = "get" . $property;
            $row[] = $entity->$method() ?? '';
        }


        $table
            ->setHeaders($headers)
            ->setRows([$row]);

        $table->render();
    }
}
