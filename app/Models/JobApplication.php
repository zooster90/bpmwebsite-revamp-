<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_opening_id',
        'position',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
        'status',
        'is_read',
        'interview_date',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'interview_date' => 'datetime',
    ];

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new'         => 'New',
            'reviewed'    => 'Reviewed',
            'interview'   => 'Interview Scheduled',
            'shortlisted' => 'Shortlisted',
            'rejected'    => 'Rejected',
            default       => 'Unknown',
        };
    }
}
