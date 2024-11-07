<?php $__env->startSection('content'); ?>
<div class="container py-3">
    <div class="col-md-8">
        <div>
            <h3 class="text-white">Вконтакте</h3>
            <p class="text-white">Среда 2 Фев, 2021</p>
        </div>

        <form action="<?php echo e(route('vk_doing')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <select name="User" id="User" class="my-select-form mb-3">
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="MessageGroup" id="MessageGroup" class="my-select-form mb-3">
                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($message->id); ?>"><?php echo e($message->name_group); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Кнопка "Начать" -->
            <button type="submit" name="action" value="start" class="btn btn-primary form-button mb-3">Начать</button>

            
        </form>


    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\projects\Kuch\resources\views/page/vk_page.blade.php ENDPATH**/ ?>