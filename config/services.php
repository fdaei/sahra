<?php

declare(strict_types=1);

return [

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
     | Figma personal access token — used only by scripts/export-figma-assets.sh
     | for local/manual asset re-exports (docs/ASSET-MANIFEST.md). Never called
     | at runtime by the application itself.
     */
    'figma' => [
        'token' => env('FIGMA_TOKEN'),
    ],

];
