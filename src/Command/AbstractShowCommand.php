<?php

namespace App\Command;

use App\Repository\Contracts\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractShowCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(null);

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');

        if ($this->canAcceptArgument()) {
            $this->addArgument('name', InputArgument::OPTIONAL);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository(get_class($this->getEntity()));

        if ($this->canAcceptArgument() && $input->getArgument("name")) {
            $entities = [$repository->get($input->getArgument("name"))];

        } else {
            $entities = $repository->getAll();
        }

        $table = new Table($output);

        $table->setHeaders($this->getTableHeaders());
        $table->setRows($this->getRows($entities));

        $table->render();
    }

    abstract public function getEntity();

    abstract public function canAcceptArgument();

    abstract public function getTableHeaders();

    abstract public function getTableRows($entities);

    private function getRows(array $entities)
    {
        return array_map(function($entity){
            return $this->getTableRows($entity);
        }, $entities);
    }
}
