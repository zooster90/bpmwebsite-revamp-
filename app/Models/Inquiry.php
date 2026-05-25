<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'category',
        'message', 'status', 'admin_notes', 'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    // Scope: active (not archived)
    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    // Scope: archived only
    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function isArchived(): bool
    {
        return !is_null($this->archived_at);
    }
}
