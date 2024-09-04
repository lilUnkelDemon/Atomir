<?php $__env->startSection('title'); ?>
    Create Article
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2><?php echo e($title); ?></h2>
    <?php if($auth): ?>
        <h1>Logged in</h1>
    <?php endif; ?>
    <form action="/articles/create?id=12" method="post">
        <input type="text" name="title" placeholder="Title">
        <input type="submit" value="Create">
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/herrteufel/Projeketen/meinproject/Atomir/resources/views/articles/create.blade.php ENDPATH**/ ?>