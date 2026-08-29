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

    /**
     * Analytics/tracking IDs, entered in Filament → Site settings →
     * Integrations & analytics. Each snippet is skipped entirely when its ID
     * is blank, so an unconfigured integration renders nothing.
     */
    $integrations = \App\Support\SiteSettings::integrations();
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>" dir="<?php echo e($direction); ?>" class="<?php echo e($fontClass); ?> antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($integrations['gtmId'])): ?>
        
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer',<?php echo e(Illuminate\Support\Js::from($integrations['gtmId'])); ?>);</script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($integrations['gscVerification'])): ?>
        <meta name="google-site-verification" content="<?php echo e($integrations['gscVerification']); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#231F20">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($config['font'] === 'arabic'): ?>
        <link rel="preload" href="/fonts/doran/DoranFaNum-Regular.ttf" as="font" type="font/ttf" crossorigin>
        <link rel="preload" href="/fonts/doran/DoranFaNum-Medium.ttf" as="font" type="font/ttf" crossorigin>
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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($integrations['gaId'])): ?>
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($integrations['gaId']); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', <?php echo e(Illuminate\Support\Js::from($integrations['gaId'])); ?>);
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($integrations['hotjarId'])): ?>
        
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:<?php echo e((int) $integrations['hotjarId']); ?>,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.ts']); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
</head>
<body class="bg-paper text-neutral-900">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($integrations['gtmId'])): ?>
        
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo e($integrations['gtmId']); ?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:inline-start-4 focus:z-modal
              focus:rounded-sm focus:bg-ink focus:px-4 focus:py-3 focus:text-paper">
        <?php echo e(__('common.skip_to_content')); ?>

    </a>

    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } elseif (config('inertia.use_script_element_for_initial_page')) { ?><script data-page="app" type="application/json"><?php echo json_encode($page); ?></script><div id="app"></div><?php } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
</body>
</html>
<?php /**PATH /home/fdaei/workspace/mine/sahra/resources/views/app.blade.php ENDPATH**/ ?>