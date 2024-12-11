<?php

namespace MrWolfGb\LaravelUpdateCreator\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class UpdateCreatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:create {--d= : Backup from date and time} {--v= : Update version} {--c= : Clean after zipping}';

    protected $description = 'Command to generate update zip file for laravel application';

    public function handle(): void
    {
        $sinceDate = $this->option('d') ?: $this->ask('Please enter date', today()->toDateTimeString(config('laravel-update-creator.datetime_used', 'minute')));
        $sinceDate = Carbon::parse($sinceDate)->toDateTimeString(config('laravel-update-creator.datetime_used', 'minute'));
        $version = $this->option('v') ?: $this->ask('Please enter update version', config('laravel-update-creator.default_version', '1.0.0'));
        $updateDir = base_path(config('laravel-update-creator.update_dir_name'));
        $dirFileName = config('laravel-update-creator.update_file_prefix', 'Update') . "_" . Str::slug($sinceDate . '_' . $version, '_');
        $outputDir = "$updateDir/$dirFileName";
        $zipFile = "$outputDir.zip";
        $excludedDirs = (array)config('laravel-update-creator.excluded_dirs', [
            'bootstrap/cache', 'storage/framework', 'storage/logs', '.vscode',
            '.idea', 'updates', 'node_modules', 'database/sql', '.git'
        ]);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $this->info('Starting to create update with name: ' . $zipFile);
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path(), RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getMTime() >= strtotime($sinceDate)) {
                $absolutePath = $file->getPathname();
                $relativePath = substr($absolutePath, strlen(base_path()) + 1);

                $skipFile = false;
                foreach ($excludedDirs as $excludedDir) {
                    $excludedPath = realpath(base_path($excludedDir));
                    if ($excludedPath && str_starts_with($absolutePath, $excludedPath)) {
                        $skipFile = true;
                        break;
                    }
                }
                if ($skipFile) {
                    continue;
                }

                $targetPath = $outputDir . DIRECTORY_SEPARATOR . $relativePath;
                if (!is_dir(dirname($targetPath))) {
                    mkdir(dirname($targetPath), 0777, true);
                }
                copy($absolutePath, $targetPath);
            }
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($outputDir, RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($outputDir) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            $this->info("ZIP file created successfully: $zipFile");
        } else {
            $this->error("Failed to create ZIP file.");
            return;
        }

        if (empty($this->option('c'))) $this->deleteDirectory($outputDir);
    }

    private function deleteDirectory(string $directory): void
    {
        $files = array_diff(scandir($directory), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $directory . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }
        rmdir($directory);
    }
}

