<?php

namespace Torann\DatabaseBackup\Databases;

class Mysql extends AbstractDatabase
{
    /**
     * {@inheritdoc}
     */
    public function getBackupCommand()
    {
        return sprintf('mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            escapeshellarg($this->config('host')),
            escapeshellarg($this->config('port')),
            escapeshellarg($this->config('username')),
            escapeshellarg($this->config('password')),
            escapeshellarg($this->config('database')),
            escapeshellarg($this->getTempPath())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRestoreCommand($file_path)
    {
        return sprintf('mysql --host=%s --port=%s --user=%s --password=%s %s -e "source %s"',
            escapeshellarg($this->config('host')),
            escapeshellarg($this->config('port')),
            escapeshellarg($this->config('username')),
            escapeshellarg($this->config('password')),
            escapeshellarg($this->config('database')),
            $file_path
        );
    }
}
