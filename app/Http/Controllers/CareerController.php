<?php

namespace App\Http\Controllers;

use App\Models\JobOpening;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobApplicationNotification;

class CareerController extends Controller
{
    /**
     * 显示招聘页面
     * 优化：采用 sort_order 排序，确保前端显示顺序与你在后台设置的一致
     */
    public function index()
    {
        // 只抓取后台开启 (is_active) 的职位
        $jobs = JobOpening::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('closing_date')
                      ->orWhere('closing_date', '>=', now());
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch culture stories for "Life at Builtech" section.
        // Eager-load media so the section doesn't fire one query per event.
        $cultureEvents = \App\Models\CultureEvent::with(['media', 'category'])
            ->orderBy('event_date', 'desc')
            ->take(6)
            ->get();

        return view('careers', compact('jobs', 'cultureEvents'));
    }

    /**
     * 处理求职申请提交
     * 修复：确保文件存储安全，并完整保存所有申请记录
     */
    public function apply(Request $request)
    {
        // Honeypot check
        if ($request->filled('fax_number')) {
            \Log::warning('Spam detected in Career form: ' . $request->ip());
            return redirect()->route('careers')->with('success', 'Thank you for your application.');
        }

        // 1. 严格的数据验证
        $validated = $request->validate([
            'job_opening_id'    => 'nullable|exists:job_openings,id',
            'position'          => 'required|string|max:255',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|max:30',
            'expected_salary'   => 'nullable|string|max:255',
            'availability'      => 'nullable|string|max:255',
            'cover_letter'      => 'nullable|string|max:5000',
            'resume'            => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        try {
            // 2. 数据库事务处理，确保数据一致性
            return DB::transaction(function () use ($request, $validated) {
                
                $resumePath = null;
                if ($request->hasFile('resume')) {
                    // 存储到 public 磁盘的 resumes 目录
                    $resumePath = $request->file('resume')->store('resumes', 'public');
                }

                // Concatenate quick questions into cover letter for record keeping
                $fullCoverLetter = "EXPECTED SALARY: " . ($validated['expected_salary'] ?? 'N/A') . "\n" .
                                  "AVAILABILITY: " . ($validated['availability'] ?? 'N/A') . "\n\n" .
                                  "MESSAGE:\n" . ($validated['cover_letter'] ?? 'N/A');

                // 3. 创建申请记录
                $application = JobApplication::create([
                    'job_opening_id' => $validated['job_opening_id'] ?? null,
                    'position'       => $validated['position'],
                    'name'           => $validated['name'],
                    'email'          => $validated['email'],
                    'phone'          => $validated['phone'],
                    'cover_letter'   => $fullCoverLetter,
                    'resume_path'    => $resumePath,
                    'status'         => 'new',
                    'is_read'        => false,
                ]);

                // 4. Send Notification to HR
                try {
                    Mail::to(config('mail.from.address', 'hr@builtech.com.my'))->send(new JobApplicationNotification($application));
                    
                    // Database Notification for Filament
                    $admins = \App\Models\User::all();
                    if (class_exists('\Filament\Notifications\Notification')) {
                        \Filament\Notifications\Notification::make()
                            ->title('New Job Application Received')
                            ->body("**Applicant:** {$application->name}\n**Position:** {$application->position}\n**Email:** {$application->email}\n**Phone:** {$application->phone}")
                            ->icon('heroicon-o-user-circle')
                            ->iconColor('success')
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->button()
                                    ->url(fn() => "/admin/job-applications/{$application->id}/edit"),
                            ])
                            ->sendToDatabase($admins);
                    }

                } catch (\Exception $e) {
                    \Log::error('HR Notification failed: ' . $e->getMessage());
                }

                // 5. 重定向并返回友好的成功提示
                return redirect()->route('careers')
                    ->with('success', 'Thank you, ' . $validated['name'] . '! Your application for the ' . $validated['position'] . ' position has been successfully submitted. Our HR team (hr@builtech.com.my) will review it shortly.');
            });

        } catch (\Exception $e) {
            // 如果发生错误（如文件系统写入失败），删除已上传的文件并报错
            if (isset($resumePath)) {
                Storage::disk('public')->delete($resumePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, something went wrong while saving your application. Please try again or contact us directly.');
        }
    }
}