<?php

namespace Torann\DatabaseBackup\Console;

class BackupCommand extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the default database.';

    /**
     * Fire the backup command.
     *
     * @return void
     */
    public function fire()
    {
        $this->output->write('Backing up database...');

        $this->process('backup');

        $this->output->writeln('<comment>Complete</comment>');
    }
}
