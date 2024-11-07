<?php $__env->startSection('content'); ?>
<div class="container py-3">
    <div class="col-md-8">
        <form action="<?php echo e(route('New_user')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <p class="text-white">Введите имя аккаунта</p>
                <input placeholder="Имя аккаунта" class="form-input" name="name" autofocus>
            </div>

            <div class="mb-3">
                <p class="text-white">Введите API HASH</p>
                <input placeholder="API hash" class="form-input" name="Hash">
            </div>

            <button class="w-100 btn btn-primary form-button">Создать</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\projects\Kuch\resources\views/Doing\AddList_user.blade.php ENDPATH**/ ?>