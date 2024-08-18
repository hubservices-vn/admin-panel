<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * Get the project that owns the page.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
