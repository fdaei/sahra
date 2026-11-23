<?php

declare(strict_types=1);

// Run on the development computer after npm run build. No host commands.
if (PHP_SAPI !== 'cli') {
    exit(1);
}
$source = dirname(__DIR__);
$destination = $argv[1] ?? '';
if (! preg_match('~^/tmp/sdk-cpanel-[a-zA-Z0-9-]+$~', $destination) || file_exists($destination)) {
    fwrite(STDERR, "Usage: php scripts/build-cpanel.php /tmp/sdk-cpanel-UNIQUE (new directory only)\n");
    exit(1);
}
if (! is_file($source.'/public/build/manifest.json')) {
    throw new RuntimeException('Run npm run build first.');
}
mkdir($destination, 0755, true);
$private = $destination.'/sahra';
$public = $destination.'/public_html';

function copyReleaseTree(string $from, string $to): void
{
    if (is_link($from)) {
        return;
    } // Never dereference local storage symlinks.
    if (is_dir($from)) {
        if (! is_dir($to)) {
            mkdir($to, 0755, true);
        }
        foreach (new DirectoryIterator($from) as $entry) {
            if ($entry->isDot()) {
                continue;
            }
            copyReleaseTree($entry->getPathname(), $to.'/'.$entry->getFilename());
        }
    } else {
        if (! is_dir(dirname($to))) {
            mkdir(dirname($to), 0755, true);
        }
        if (! copy($from, $to)) {
            throw new RuntimeException("Copy failed: {$from}");
        }
    }
}

foreach (['app', 'config', 'lang', 'resources', 'routes', 'vendor', 'database/migrations'] as $directory) {
    copyReleaseTree($source.'/'.$directory, $private.'/'.$directory);
}
foreach (['artisan', 'composer.json', 'composer.lock'] as $file) {
    copyReleaseTree($source.'/'.$file, $private.'/'.$file);
}
copyReleaseTree($source.'/bootstrap/app.php', $private.'/bootstrap/app.php');
copyReleaseTree($source.'/bootstrap/providers.php', $private.'/bootstrap/providers.php');
copyReleaseTree($source.'/.env.cpanel.example', $private.'/.env.example');
foreach (['bootstrap/cache', 'storage/app/private', 'storage/app/public', 'storage/framework/cache/data', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs'] as $directory) {
    if (! is_dir($private.'/'.$directory)) {
        mkdir($private.'/'.$directory, 0755, true);
    }
}
copyReleaseTree($source.'/public', $public);
// Preserve WebP on resize and upload AVIF unchanged (browsers may lack an AVIF encoder).
$uploadScript = $public.'/js/filament/forms/components/file-upload.js';
$script = file_get_contents($uploadScript);
$oldMimeFallback = 'xu=e=>/jpeg|png|svg\\+xml/.test(e)?e:"image/jpeg"';
$webpMimeFallback = 'xu=e=>/jpeg|png|webp|svg\\+xml/.test(e)?e:"image/jpeg"';
if (! is_string($script) || (! str_contains($script, $oldMimeFallback) && ! str_contains($script, $webpMimeFallback))) {
    throw new RuntimeException('Could not verify the Filament WebP upload fix; review the current FilePond bundle.');
}
if (str_contains($script, $oldMimeFallback)) {
    $script = str_replace($oldMimeFallback, $webpMimeFallback, $script);
}
$filterOld = 'imageTransformOutputStripImageHead:!1,';
$filterNew = 'imageTransformOutputStripImageHead:!1,imageTransformImageFilter:e=>e.type!=="image/avif",';
$editorOld = 'saveEditor:function(){if(r||!h)return;';
$editorNew = 'saveEditor:function(){if(r||!h)return;if(this.editingFile.type==="image/avif"){alert("AVIF images are uploaded unchanged. Crop this image before uploading.");return;}';
if (substr_count($script, $filterNew) === 0 && substr_count($script, $filterOld) === 1) {
    $script = str_replace($filterOld, $filterNew, $script);
}
if (substr_count($script, $editorNew) === 0 && substr_count($script, $editorOld) === 1) {
    $script = str_replace($editorOld, $editorNew, $script);
}
if (substr_count($script, $filterNew) !== 1 || substr_count($script, $editorNew) !== 1) {
    throw new RuntimeException('Could not verify the Filament AVIF upload fix; review the current FilePond bundle.');
}
if (file_put_contents($uploadScript, $script) === false) {
    throw new RuntimeException('Could not apply the Filament image upload fixes.');
}
// public/hot would make Laravel request a development Vite server.
if (is_file($public.'/hot')) {
    unlink($public.'/hot');
}
copyReleaseTree($source.'/deployment/cpanel/index.php', $public.'/index.php');
if (! is_dir($public.'/storage')) {
    mkdir($public.'/storage', 0755, true);
}
file_put_contents($public.'/storage/.htaccess', "Options -Indexes\n<FilesMatch \"\\.(?:php[0-9]?|phtml|phar)$\">\nRequire all denied\n</FilesMatch>\n");

// Rebuild the staging autoloader for runtime dependencies only. The working
// checkout, its vendor directory and .env are never changed by this script.
$process = proc_open(['composer', 'install', '--no-dev', '--no-scripts', '--no-interaction', '--prefer-dist', '--optimize-autoloader'], [STDIN, STDOUT, STDERR], $pipes, $private);
if (! is_resource($process) || proc_close($process) !== 0) {
    throw new RuntimeException('Production Composer install failed.');
}

copyReleaseTree($source.'/docs/DEPLOY-CPANEL-FA.md', $destination.'/DEPLOY-CPANEL-FA.md');
copyReleaseTree($source.'/docs/SEO-REPORT-FA.md', $destination.'/SEO-REPORT-FA.md');
$zip = new ZipArchive;
$zipPath = $destination.'.zip';
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::EXCL) !== true) {
    throw new RuntimeException('Cannot create upload archive.');
}
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($destination, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
foreach ($files as $file) {
    $relative = substr($file->getPathname(), strlen($destination) + 1);
    if ($file->isDir()) {
        $zip->addEmptyDir($relative);
    } else {
        $zip->addFile($file->getPathname(), $relative);
    }
}
$zip->close();
echo "Upload archive: {$zipPath}\nSHA256: ".hash_file('sha256', $zipPath)."\n";
