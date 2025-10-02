<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllQuestionSection extends Model
{
    protected $fillable = ['name', 'order', 'survey_id'];

    public function questions()
    {
        return $this->hasMany(AllQuestion::class, 'section_id');
    }
}
