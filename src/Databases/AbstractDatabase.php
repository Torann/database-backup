<?php

namespace Torann\DatabaseBackup\Databases;

use Illuminate\Support\Arr;

abstract class AbstractDatabase
{
    /**
     * The backup file path.
     *
     * @var string
     */
    protected $file_path;

    /**
     * The backup filename.
     *
     * @var string
     */
    protected $filename;

    /**
     * Dumper configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Initializes the database instance.
     *
     * @param array  $config
     *
     * @return self
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Return the temporary dump file.
     *
     * @return string
     */
    public function getTempPath()
    {
        if ($this->file_path === null) {
            $this->file_path = sys_get_temp_dir() . '/' . str_random(4) . '-' . $this->getFilename();
        }

        return $this->file_path;
    }

    /**
     * Return the filename for the given dump.
     *
     * @return string
     */
    public function getFilename()
    {
        if ($this->filename === null) {
            $this->filename = $this->config('database') . '-' . date('Y-m-d_H-i-s') . '.sql';
        }

        return $this->filename;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  string  $key
     * @param  mixed   $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Return the backup command for the given database.
     *
     * @return string
     */
    abstract public function getBackupCommand();

    /**
     * Return the restore command for the given database.
     *
     * @param string $file_path
     *
     * @return string
     */
    abstract public function getRestoreCommand($file_path);
}