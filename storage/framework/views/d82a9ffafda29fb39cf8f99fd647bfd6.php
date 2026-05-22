<?php $__env->startSection('title', 'Staff Login | Builtech Project Management Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-[#001F3F] relative overflow-hidden">
    
    <div class="absolute inset-0 opacity-5"
         style="background-image:linear-gradient(rgba(255,255,255,.15) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.15) 1px,transparent 1px);background-size:48px 48px;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full"
         style="background:radial-gradient(circle,rgba(197,160,89,.12) 0%,transparent 70%);pointer-events:none;"></div>

    <div class="relative z-10 w-full max-w-md px-6 py-12">
        
        <div class="text-center mb-10">
            <img src="<?php echo e(asset('/img/images/61da7874-55a9-46d1-b71c-32ddac2a7740.png')); ?>"
                 alt="Builtech" class="h-14 w-auto mx-auto mb-6 brightness-0 invert">
            <h1 style="font-family:'Oswald',sans-serif;color:#fff;font-size:1.5rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.4rem;">
                Staff Portal
            </h1>
            <p style="color:rgba(255,255,255,.4);font-size:.8rem;font-family:'Inter',sans-serif;">
                Authorised personnel only
            </p>
        </div>

        
        <div class="bg-[#0a2e52] rounded-2xl p-8 border border-white/10 shadow-2xl">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-300 p-4 rounded-xl mb-6 text-sm">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 p-4 rounded-xl mb-6 text-sm">
                <?php echo e(session('status')); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label" style="color:rgba(255,255,255,.4)" for="login_email">Email Address</label>
                    <input id="login_email" type="email" name="email" required autofocus
                           class="form-input form-input-dark"
                           value="<?php echo e(old('email')); ?>"
                           placeholder="your@builtech.com.my">
                </div>
                <div>
                    <label class="form-label" style="color:rgba(255,255,255,.4)" for="login_password">Password</label>
                    <input id="login_password" type="password" name="password" required
                           class="form-input form-input-dark"
                           placeholder="••••••••••">
                </div>
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-[#C5A059]">
                        <span style="font-size:.72rem;color:rgba(255,255,255,.4);font-family:'Inter',sans-serif;">Remember me</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-gold w-full" style="justify-content:center;font-size:.72rem;margin-top:.5rem;">
                    Sign In <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
        </div>

        <div class="text-center mt-8">
            <a href="<?php echo e(route('home')); ?>"
               style="color:rgba(255,255,255,.3);font-size:.72rem;font-family:'Inter',sans-serif;text-decoration:none;transition:color .3s;"
               onmouseover="this.style.color='#C5A059'" onmouseout="this.style.color='rgba(255,255,255,.3)'">
                <i class="fas fa-arrow-left mr-1"></i> Return to Website
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/login.blade.php ENDPATH**/ ?>