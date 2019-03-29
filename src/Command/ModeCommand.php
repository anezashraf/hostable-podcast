<?php

namespace App\Command;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ModeCommand
 * @package App\Command
 */
final class ModeCommand extends Command
{
    public const ARGUMENT = 'mode_arg';
    public const ACCEPT_ARGUMENTS = ['online', 'offline'];

    /**
     * @var string
     */
    protected static $defaultName = 'mode';

    /**
     * @var SettingRepository
     */
    private $repository;

    /**
     * ModeCommand constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        parent::__construct(null);

        $this->repository = $settingRepository;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Places the website either in `online` mode or `offline` mode')
            ->addArgument(self::ARGUMENT, InputArgument::REQUIRED, 'offline or online');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws NoResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyOutput = new SymfonyStyle($input, $output);

        /** @var string $argument */
        $argument = $input->getArgument(self::ARGUMENT);

        if (! in_array($argument, self::ACCEPT_ARGUMENTS)) {
            $symfonyOutput->error("Incorrect argument, must be `online` or `offline`");
            return 1;
        }

        $value = $argument === 'online' ? 'true' : 'false';

        $this->repository->update(['name' => Setting::IS_ONLINE, 'value' => $value]);

        $symfonyOutput->text("Your hostable podcast is now ${argument}");
    }
}
