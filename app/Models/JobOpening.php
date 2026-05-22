<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOpening extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['title', 'slug', 'department', 'location', 'type', 'description', 'is_active', 'closing_date'];

    protected $casts = [
        'is_active' => 'boolean',
        'closing_date' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions { return LogOptions::defaults()->logFillable(); }
}
