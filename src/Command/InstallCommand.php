<?php


namespace App\Command;

use App\Installation\InstallerException;
use App\Installation\PodcastInstaller;
use App\Installation\SettingsInstaller;
use App\Installation\InstallQuestion;
use App\Installation\UserInstaller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'install';
    private $installers;

    public function __construct(
        SettingsInstaller $settingsInstaller,
        UserInstaller $userInstaller,
        PodcastInstaller $podcastInstaller
    ) {
        parent::__construct(self::$defaultName);

        $this->installers = [$settingsInstaller, $userInstaller, $podcastInstaller];
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyOutput = new SymfonyStyle($input, $output);

        foreach ($this->installers as $installer) {

            /**@var InstallQuestion[] $questions */
            $questions = $installer->getQuestions();
            foreach ($questions as $question) {
                $question->setAnswer(
                    $symfonyOutput->askQuestion($question)
                );
            }
            $installer->setQuestions($questions);

            try {
                $message = $installer->install();
                $symfonyOutput->writeln($message);
            } catch (InstallerException $exception) {
                $symfonyOutput->error($exception);

                return 1;
            }
        }

        return 0;
    }
}
