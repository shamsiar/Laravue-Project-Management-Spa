<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectTask extends Pivot
{
    use HasFactory;

    // public function projects()
    // {
    //     return $this->hasMany(Project::class, 'projects');
    // }

    // public function tasks()
    // {
    //     return $this->hasMany(Task::class, 'tasks');
    // }
}
