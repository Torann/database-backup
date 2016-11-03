<?php

namespace Torann\DatabaseBackup\Processors;

interface ProcessorInterface
{
    /**
     * Executes the given command.
     *
     * @param  string $command
     *
     * @return void
     */
    public function process($command);

    /**
     * Returns errors which happened during the command execution.
     *
     * @return string|null
     */
    public function getErrors();
}