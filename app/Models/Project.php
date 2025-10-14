<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
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
