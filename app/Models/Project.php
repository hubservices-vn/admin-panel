<?php


namespace App\Models;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            // Automatically set the user_id to the currently authenticated user
            $project->user_id = Auth::id();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pages for the project.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
