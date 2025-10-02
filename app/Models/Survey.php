<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'project_id',
        'status',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function allQuestions()
    {
        return $this->hasMany(AllQuestion::class);
    }
}
