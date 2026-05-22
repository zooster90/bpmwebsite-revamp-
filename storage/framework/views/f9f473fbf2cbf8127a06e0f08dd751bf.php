
                                                <div style="display: flex; flex-direction: column; gap: 12px;">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = \Spatie\Activitylog\Models\Activity::where("causer_id", $record->id)->latest()->take(15)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 12px; border: 1px solid #f3f4f6; background-color: #f9fafb;">
                                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                                <div style="width: 32px; height: 32px; border-radius: 10px; background-color: <?php if(str_contains($log->description, "created")): ?> #ecfdf5 <?php elseif(str_contains($log->description, "deleted")): ?> #fef2f2 <?php else: ?> #fff7ed <?php endif; ?>; display: flex; align-items: center; justify-content: center;">
                                                                    <?php
                                                                        $icon = match(class_basename($log->subject_type)) {
                                                                            "Project" => "🏗️", "Inquiry" => "📧", "News" => "📰", "Award" => "🏆", "User" => "👤", default => "⚙️",
                                                                        };
                                                                    ?>
                                                                    <span style="font-size: 16px;"><?php echo e($icon); ?></span>
                                                                </div>
                                                                <div>
                                                                    <div style="font-size: 14px; font-weight: 700; color: #111827; text-transform: capitalize;"><?php echo e($log->description); ?></div>
                                                                    <div style="font-size: 12px; color: #6b7280;"><?php echo e(class_basename($log->subject_type)); ?></div>
                                                                </div>
                                                            </div>
                                                            <div style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo e($log->created_at->diffForHumans()); ?></div>
                                                        </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        <div style="text-center; padding: 32px 0; color: #9ca3af; font-style: italic; font-size: 14px;">No recent activity found for this administrator.</div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php /**PATH C:\Users\built\Herd\builtech-app\storage\framework\views/a220ec95f64ff6e7071dcd614e321164.blade.php ENDPATH**/ ?>