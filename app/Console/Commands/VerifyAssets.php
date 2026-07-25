<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Walks docs/ASSET-MANIFEST.md and reports which required assets are missing.
 *
 * Run after exporting from Figma to confirm nothing was skipped.
 */
final class VerifyAssets extends Command
{
    protected $signature = 'sahra:verify-assets';

    protected $description = 'Check that every asset listed in the manifest exists on disk';

    /**
     * Representative paths per manifest section. Directories are checked for
     * a minimum file count rather than listing every filename.
     *
     * @var array<string, array{path: string, min: int, note: string}>
     */
    private const CHECKS = [
        'Branding' => [
            'path' => 'resources/images/branding',
            'min' => 3,
            'note' => 'logo-full.svg, logo-mark.svg, logotype.svg',
        ],
        'Client logos' => [
            'path' => 'resources/images/clients',
            'min' => 6,
            'note' => 'six client SVGs',
        ],
        'Decorative vectors' => [
            'path' => 'resources/images/decor',
            'min' => 7,
            'note' => 'arc rings, dune contours, service orbit',
        ],
        'Bespoke icons' => [
            'path' => 'resources/images/icons',
            'min' => 3,
            'note' => 'industry, menu, search',
        ],
        'Poppins webfonts' => [
            'path' => 'public/fonts/poppins',
            'min' => 4,
            'note' => 'run ./scripts/fetch-fonts.sh',
        ],
        'Vazirmatn webfonts' => [
            'path' => 'public/fonts/vazirmatn',
            'min' => 3,
            'note' => 'run ./scripts/fetch-fonts.sh',
        ],
    ];

    public function handle(): int
    {
        $failures = 0;

        $this->info('Verifying assets against docs/ASSET-MANIFEST.md');
        $this->newLine();

        foreach (self::CHECKS as $label => $check) {
            $path = base_path($check['path']);

            $count = File::isDirectory($path)
                ? count(File::files($path))
                : 0;

            if ($count >= $check['min']) {
                $this->line("  <fg=green>OK</>    {$label} ({$count} files)");

                continue;
            }

            $failures++;
            $this->line("  <fg=red>MISS</>  {$label} — found {$count}, expected {$check['min']} — {$check['note']}");
        }

        $this->newLine();

        // Doran is licensed separately; report as a warning, never a failure.
        $doran = base_path('public/fonts/doran');
        $doranCount = File::isDirectory($doran) ? count(File::files($doran)) : 0;

        if ($doranCount < 3) {
            $this->warn('  Doran FaNum not installed — FA/AR fall back to Vazirmatn.');
            $this->line('  See docs/ASSET-MANIFEST.md §10 (commercial licence required).');
            $this->newLine();
        }

        if ($failures > 0) {
            $this->error("{$failures} asset group(s) incomplete.");

            return self::FAILURE;
        }

        $this->info('All required asset groups present.');

        return self::SUCCESS;
    }
}
