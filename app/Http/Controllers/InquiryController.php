<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryNotification;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot check
        if ($request->filled('fax_number')) {
            \Log::warning('Spam detected in Inquiry form: ' . $request->ip());
            return redirect()->route('contact')->with('success', 'Thank you for your message.'); // Falsely report success to bots
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:50',
            'category' => 'nullable|string|max:255',
            'subject'  => 'nullable|string|max:255',
            'message'  => 'required|string|min:10',
        ]);

        $inquiry = Inquiry::create($validated);

        // Send Notification to Admin
        try {
            Mail::to(config('mail.from.address'))->send(new InquiryNotification($inquiry));
            
            // Database Notification for Filament
            $admins = \App\Models\User::all();
            \Filament\Notifications\Notification::make()
                ->title('New Business Inquiry Received')
                ->body("**From:** {$inquiry->name} ({$inquiry->email})\n**Phone:** " . ($inquiry->phone ?? 'N/A') . "\n**Type:** " . ($inquiry->category ?: 'General Inquiry') . "\n\n**Message:**\n" . \Illuminate\Support\Str::limit($inquiry->message, 150))
                ->icon('heroicon-o-briefcase')
                ->iconColor('primary')
                ->actions([
                    \Filament\Notifications\Actions\Action::make('view')
                        ->button()
                        ->url(fn() => "/admin/inquiries/{$inquiry->id}/edit"),
                ])
                ->sendToDatabase($admins);
                
        } catch (\Exception $e) {
            \Log::error('Inquiry Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('contact')->with(
            'success',
            'Thank you for reaching out, ' . $inquiry->name . '. We have successfully received your inquiry regarding ' . ($inquiry->category ? ucwords(str_replace('_', ' ', $inquiry->category)) : 'your project') . '. A representative from our team will review your details and contact you shortly.'
        );
    }
}
