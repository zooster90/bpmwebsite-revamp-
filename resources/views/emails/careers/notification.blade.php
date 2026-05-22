<x-mail::message>
# New Job Application Received

A new application has been submitted for the position of **{{ $application->position }}**.

**Applicant Details:**
- **Name:** {{ $application->name }}
- **Email:** {{ $application->email }}
- **Phone:** {{ $application->phone ?? 'N/A' }}

**Cover Letter / Notes:**
{{ $application->cover_letter ?? 'No cover letter provided.' }}

**Resume:**
The applicant's resume is attached to this email.

<x-mail::button :url="config('app.url') . '/admin/job-applications/' . $application->id">
Review Application
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
