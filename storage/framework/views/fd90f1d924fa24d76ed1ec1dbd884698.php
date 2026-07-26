<div
    x-data="{}"
    x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
    <?php echo e($attributes->class(['inline-block'])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH /home/fdaei/project/my/sahra-fullstack/sahra/vendor/filament/notifications/resources/views/components/database/trigger.blade.php ENDPATH**/ ?>