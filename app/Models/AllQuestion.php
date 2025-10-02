<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllQuestion extends Model
{
   protected $fillable = [
        'survey_id',
        'question_type',
        'question_text',
        'question_options',
        'section_id',
        'order',
    ];

    protected $casts = [
        'question_options' => 'array',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function section()
    {
        return $this->belongsTo(AllQuestionSection::class, 'section_id');
    }
}
