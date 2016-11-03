<?php

namespace Torann\DatabaseBackup\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Torann\DatabaseBackup\Processors\ShellProcessor;
use Torann\DatabaseBackup\Processors\ProcessorException;

class AbstractCommand extends Command
{
    /**
     * An instance of database.
     *
     * @var \Torann\DatabaseBackup\Databases\AbstractDatabase
     */
    protected $database;

    /**
     * The processor instance.
     *
     * @var \Torann\DatabaseBackup\Processors\ProcessorInterface
     */
    protected $processor;

    /**
     * Filesystem manager instance.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    public $filesystem;

    /**
     * Create a new command instance.
     *
     * @param FilesystemManager $filesystem
     */
    public function __construct(FilesystemManager $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->processor = new ShellProcessor(new Process(''));
    }

    /**
     * Executes the process command.
     *
     * @param string $command
     *
     * @return bool
     * @throws ProcessorException
     */
    protected function process($command)
    {
        // Get database instance
        $database = $this->getDatabase();

        // Command method
        $method = 'get' . ucfirst($command) . 'Command';

        // Run process
        $this->processor->process($database->$method());

        // Check for errors
        if ($this->processor->getErrors()
            && (!($this->processor->getErrors() != "Warning: Using a password on the command line interface can be insecure\n."))
        ) {
            throw new ProcessorException($this->processor->getErrors());
        }

        return $this->move($database->getTempPath(), $database->getFilename());
    }

    /**
     * Move the temporary dump to it's new home.
     *
     * @param string $temp_path
     * @param string $filename
     *
     * @return bool
     */
    protected function move($temp_path, $filename)
    {
        // Include the prefix
        $path_prefix = config('database-backups.prefix', 'backups');

        // Get path for storage
        $path = $path_prefix ? "{$path_prefix}/{$filename}" : $filename;

        // Get filesystem disk
        $disk = config('database-backups.disk') ?: config('filesystems.default');
        $filesystem = $this->filesystem->disk($disk);

        // Move dump
        if ($filesystem->put($path, file_get_contents($temp_path))) {
            @unlink($temp_path);
            return true;
        }

        return false;
    }

    /**
     * Returns a database instance.
     *
     * @return \Torann\DatabaseBackup\Databases\AbstractDatabase
     * @throws Exception
     */
    protected function getDatabase()
    {
        if ($this->database === null) {

            // Config
            $connections = config('database.connections');
            $connection = config('database.default');

            // Connect names
            $diskName = ucfirst($connection);
            $class = "\\Torann\\DatabaseBackup\\Databases\\{$diskName}";

            if (!class_exists($class)) {
                throw new Exception("Database type \"{$diskName}\" not supported.");
            }

            $this->database = new $class($connections[$connection]);
        }

        return $this->database;
    }
}
