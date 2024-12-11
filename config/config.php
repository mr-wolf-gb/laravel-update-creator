<?php

return [
    /*
     * Specifies the directory name where update files will be stored.
     * Default Value: 'updates'
     */
    'update_dir_name' => env('LARAVEL_UPDATE_DIR', 'updates'),
    /*
     * Defines the prefix used for naming the update files.
     * Default Value: 'Update'
     */
    'update_file_prefix' => env('LARAVEL_UPDATE_FILE_PREFIX', 'Update'),
    /*
     * Options: minute, second, millisecond, microsecond
     */
    'datetime_used' => env('LARAVEL_UPDATE_DATETIME_USED', 'minute'),
    /*
     * A list of directories to exclude from the update process.
     */
    'excluded_dirs' => env('LARAVEL_UPDATE_EXCLUDED_DIRS', [
        'bootstrap/cache',
        'storage/framework',
        'storage/logs',
        '.idea',
        '.vscode',
        'updates',
        'node_modules',
        'database/sql',
        '.git',
    ]),
    /*
     * The default version used for the update if no version is specified.
     * Default Value: '1.0.0'
     */
    'default_version' => env('LARAVEL_UPDATE_DEFAULT_VERSION', '1.0.0'),
];
