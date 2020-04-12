<?php

namespace App\CommandConfigurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DangerousCommand implements ConfiguratorInterface
{
    public function configureCommand(Command $command): void
    {
        $command->addOption('force', 'f', InputOption::VALUE_NONE, 'Skip confirmation and force execution');
    }

    public function collectUserInput(
        InputInterface $input,
        OutputInterface $output,
        Command $command,
        ConsoleCommandEvent $event
    ): void {
        if ($input->getOption('force')) {
            // we're good - execution enforced
            return;
        }
        if (!$input->isInteractive()) {
            $output->writeln(
                '<error>Confirmation required to run this command. Use --force flag to skip confirmation</error>'
            );
            $event->disableCommand();
            return;
        }
        /** @var QuestionHelper $helper */
        $helper = $command->getHelper('question');
        $question = new ConfirmationQuestion('Continue with this action? (y/N) ', false);
        if ($helper->ask($input, $output, $question)) {
            // Execution confirmed
            return;
        }
        $output->writeln('<error>Confirmation failed. Execution canceled.</error>');
        $event->disableCommand();
        return;
    }
}
