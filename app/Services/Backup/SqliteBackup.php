<?php

declare(strict_types=1);

namespace App\Services\Backup;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;
use ZipArchive;

/** Creates a private, temporary archive for download. */
class SqliteBackup
{
    public function create(): string
    {
        $connection = DB::connection();
        if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() === ':memory:') {
            throw new RuntimeException('Backups from this panel currently require a file-based SQLite database.');
        }
        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException('The PHP ZIP extension is required.');
        }

        $directory = sys_get_temp_dir().'/sahra-backup-'.bin2hex(random_bytes(16));
        if (! mkdir($directory, 0700)) {
            throw new RuntimeException('Unable to create a private temporary directory.');
        }
        $snapshot = $directory.'/database.sqlite';
        $archive = $directory.'/backup.zip';
        $download = sys_get_temp_dir().'/sahra-backup-'.bin2hex(random_bytes(16)).'.zip';
        $opened = false;
        $zip = new ZipArchive;

        try {
            // SQLite creates a consistent snapshot, including committed WAL data.
            $connection->statement('VACUUM INTO '.$connection->getPdo()->quote($snapshot));
            if ($zip->open($archive, ZipArchive::CREATE | ZipArchive::EXCL) !== true) {
                throw new RuntimeException('Unable to create the backup archive.');
            }
            $opened = true;
            if (! $zip->addFile($snapshot, 'database/database.sqlite')) {
                throw new RuntimeException('Unable to add the database snapshot.');
            }
            foreach (['public', 'local'] as $disk) {
                if (config("filesystems.disks.{$disk}.driver") !== 'local') {
                    throw new RuntimeException('Backup requires local upload disks.');
                }
                $root = config("filesystems.disks.{$disk}.root");
                if (! is_string($root) || ! is_dir($root)) {
                    continue;
                }
                $this->addDirectory($zip, $root, "uploads/{$disk}");
            }
            $zip->addFromString('README.txt', "SQLite database snapshot and public/private uploads. The application code, environment configuration, and encryption key are not included. Store this file securely.\n");
            if (! $zip->close()) {
                throw new RuntimeException('Unable to finish the backup archive.');
            }
            $opened = false;
            chmod($archive, 0600);
            if (! rename($archive, $download)) {
                throw new RuntimeException('Unable to prepare the backup for download.');
            }
            File::deleteDirectory($directory);
            return $download;
        } catch (\Throwable $exception) {
            if ($opened) {
                $zip->close();
            }
            File::deleteDirectory($directory);
            throw $exception;
        }
    }

    private function addDirectory(ZipArchive $zip, string $root, string $prefix): void
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file->isLink()) {
                throw new RuntimeException('Backup cannot include symbolic links in upload directories.');
            }
            if ($file->isFile()) {
                $relative = substr($file->getPathname(), strlen(rtrim($root, DIRECTORY_SEPARATOR)) + 1);
                if (! $zip->addFile($file->getPathname(), $prefix.'/'.str_replace(DIRECTORY_SEPARATOR, '/', $relative))) {
                    throw new RuntimeException('Unable to add an uploaded file to the backup.');
                }
            }
        }
    }
}
