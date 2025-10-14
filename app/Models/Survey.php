<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status',
        'researcher_id'
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
