<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'detail', 'user_id', 'group_id',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class)->using(ProjectTask::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->select('name', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->select(['name as text', 'id']);
    }
}
