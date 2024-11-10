

<?php $__env->startSection('content'); ?>
<div class="container py-3">
    <div class="col-md-8">
        <h2 class="text-white">Настройки</h2>

        <div class='BlockSetting mt-4'>

            
            <div>
                <h3 class="text-white">Настройки</h3>
                <p class="text-white">Среда 2 Фев, 2021</p>
            </div>

            
            <div class="mb-3" style="border-top: 1px solid white; width: 100%;"></div>

            
            <div class="mb-5">
                <h4 class="text-white">Аккаунты</h4>

                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-my-group">
                    <div class="d-flex mt-2">
                        <p><?php echo e($account->name); ?></p>
                        <p style="overflow: hidden; width: 450px; text-overflow: ellipsis;"><?php echo e($account->Hash); ?></p>
                    </div>

                    <form action="<?php echo e(secure_url('destroy_user', $account->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button type="submit" class="btn btn-primary button-delete">Удалить</button>
                    </form>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <form action="<?php echo e(secure_url('Controller_settings')); ?>">
                    <button class="btn btn-primary form-button-add">Добавить аккаунт</button>
                </form>
            </div>

            <div>
                <h4 class="text-white">Сообщения</h4>

                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-my-group">
                    <p><?php echo e($message->name_group); ?></p>

                    <form action="<?php echo e(secure_url('message_destroy', $message->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button type="submit" class="btn btn-primary button-delete">Удалить</button>
                    </form>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <form action="<?php echo e(secure_url('add_message_route')); ?>" method="GET">
                    <button class="btn btn-primary form-button-add">Добавить группу сообщений</button>
                </form>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Артём Пазин\Documents\GitHub\Kucher_site\resources\views\page\setting_page.blade.php ENDPATH**/ ?>