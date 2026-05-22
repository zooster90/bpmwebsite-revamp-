<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status'];

    public function getActivitylogOptions(): LogOptions { return LogOptions::defaults()->logFillable(); }
}
