<?php

namespace App\Command;

use App\CommandOptions\Database;
use App\Validator\IsMagentoDirectory;
use App\Validator\IsMySqlExecutableAvailable;

class DbCreate extends \Ahc\Cli\Input\Command
{
    /**
     * @var IsMySqlExecutableAvailable
     */
    private $isMySqlExecutableAvailable;
    /**
     * @var IsMagentoDirectory
     */
    private $isMagentoDirectory;

    /**
     * DbCreate constructor.
     * @param IsMySqlExecutableAvailable $isMySqlExecutableAvailable
     * @param IsMagentoDirectory $isMagentoDirectory
     */
    public function __construct(IsMySqlExecutableAvailable $isMySqlExecutableAvailable, IsMagentoDirectory $isMagentoDirectory)
    {
        parent::__construct('db:create', 'Create database');

        $this
            ->argument('[arg2]', 'The Arg2')
            ->option('-a --apple', 'The Apple')
            ->option('-b --ball', 'The ball')
            // Usage examples:
            ->usage(
                // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                '<bold>  init</end> <comment>--apple applet --ball ballon <arggg></end> ## details 1<eol/>' .
                // $0 will be interpolated to actual command name
                '<bold>  $0</end> <comment>-a applet -b ballon <arggg> [arg2]</end> ## details 2<eol/>'
            );
        Database::addOptionsToCommand($this);
        $this->isMySqlExecutableAvailable = $isMySqlExecutableAvailable;
        $this->isMagentoDirectory = $isMagentoDirectory;
    }

    // This method is auto called before `self::execute()` and receives `Interactor $io` instance
    public function interact(\Ahc\Cli\IO\Interactor $io)
    {
        $options = Database::readOptionsAndAskForMissingValues($this, $io);
        foreach ($options as $option => $value) {
            $this->set($option, $value);
        }
        // ...
    }

    // When app->handle() locates `init` command it automatically calls `execute()`
    // with correct $ball and $apple values
    public function execute($ball, $apple)
    {
        $io = $this->app()->io();

//        $this->isMySqlExecutableAvailable->execute();
//        $this->isMagentoDirectory->execute();

        $io->write('Apple ' . $apple, true);
        $io->write('Ball ' . $ball, true);

        // more codes ...

        // If you return integer from here, that will be taken as exit error code
    }
}
