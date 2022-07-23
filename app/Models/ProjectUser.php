<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    // public function projects()
    // {
    //     return $this->hasMany(Project::class, 'projects');
    // }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'users');
    // }
}
