<?php
    /**
     * Inertia root view.
     *
     * Sets lang/dir from the resolved locale so the very first paint is already
     * correct — no flash of LTR before Vue hydrates. The font class picks the
     * Poppins (EN) or Doran/Vazirmatn (FA/AR) stack defined in tailwind.config.js.
     */
    $locale    = app()->getLocale();
    $config    = config("locales.supported.{$locale}");
    $direction = $config['direction'];
    $htmlLang  = $config['html_lang'];
    $fontClass = $config['font'] === 'arabic' ? 'font-arabic' : 'font-sans';
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>" dir="<?php echo e($direction); ?>" class="<?php echo e($fontClass); ?> antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#231F20">

    
    <link rel="preconnect" href="<?php echo e(config('app.url')); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($config['font'] === 'arabic'): ?>
        <link rel="preload" href="/fonts/vazirmatn/Vazirmatn-Regular.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/fonts/vazirmatn/Vazirmatn-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <?php else: ?>
        <link rel="preload" href="/fonts/poppins/Poppins-Regular.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/fonts/poppins/Poppins-SemiBold.woff2" as="font" type="font/woff2" crossorigin>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($page['props']['alternates'])): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $page['props']['alternates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <link rel="alternate" hreflang="<?php echo e(config("locales.supported.{$code}.html_lang")); ?>" href="<?php echo e($url); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <link rel="alternate" hreflang="x-default"
              href="<?php echo e($page['props']['alternates'][config('locales.default')] ?? url('/')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.ts']); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
</head>
<body class="bg-paper text-neutral-900">
    
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:inline-start-4 focus:z-modal
              focus:rounded-sm focus:bg-ink focus:px-4 focus:py-3 focus:text-paper">
        <?php echo e(__('common.skip_to_content')); ?>

    </a>

    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } elseif (config('inertia.use_script_element_for_initial_page')) { ?><script data-page="app" type="application/json"><?php echo json_encode($page); ?></script><div id="app"></div><?php } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
</body>
</html>
<?php /**PATH /home/fdaei/Downloads/sahra-fullstack/sahra/resources/views/app.blade.php ENDPATH**/ ?>