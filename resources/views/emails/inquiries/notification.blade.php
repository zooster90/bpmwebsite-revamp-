<x-mail::message>
# New Inquiry Received

You have received a new inquiry from the Builtech Corporate Portal.

**Details:**
- **Name:** {{ $inquiry->name }}
- **Email:** {{ $inquiry->email }}
- **Phone:** {{ $inquiry->phone ?? 'N/A' }}
- **Category:** {{ ucfirst($inquiry->category ?? 'General') }}
- **Subject:** {{ $inquiry->subject ?? 'General Inquiry' }}

**Message:**
{{ $inquiry->message }}

<x-mail::button :url="config('app.url') . '/admin/inquiries/' . $inquiry->id">
View in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
