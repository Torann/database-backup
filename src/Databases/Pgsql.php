<?php

namespace Torann\DatabaseBackup\Databases;

class Pgsql extends AbstractDatabase
{
    /**
     * {@inheritdoc}
     */
    public function getBackupCommand()
    {
        return sprintf('PGPASSWORD=%s pg_dump --host=%s --port=%s --username=%s %s -f %s',
            escapeshellarg($this->config('password')),
            escapeshellarg($this->config('host')),
            escapeshellarg($this->config('port')),
            escapeshellarg($this->config('username')),
            escapeshellarg($this->config('database')),
            escapeshellarg($this->getTempPath())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRestoreCommand($file_path)
    {
        return sprintf('PGPASSWORD=%s psql --host=%s --port=%s --user=%s %s -f %s',
            escapeshellarg($this->config('password')),
            escapeshellarg($this->config('host')),
            escapeshellarg($this->config('port')),
            escapeshellarg($this->config('username')),
            escapeshellarg($this->config('database')),
            escapeshellarg($file_path)
        );
    }
}
