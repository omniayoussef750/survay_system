<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'researcher_id',
    ];
    public function researcher()
    {
        return $this->belongsTo(Researcher::class);
    }
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
