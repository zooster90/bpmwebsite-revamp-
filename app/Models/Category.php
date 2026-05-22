<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\CurrentProject;
use App\Models\Award;
use App\Models\News;
use App\Models\PressCoverage;
use App\Models\CultureEvent;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'model_type',
        'parent_id',
        'sort_order',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    public function currentProjects()
    {
        return $this->hasMany(CurrentProject::class, 'category_id');
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'category_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function pressCoverages()
    {
        return $this->hasMany(PressCoverage::class, 'category_id');
    }

    public function cultureEvents()
    {
        return $this->hasMany(CultureEvent::class, 'category_id');
    }
}
