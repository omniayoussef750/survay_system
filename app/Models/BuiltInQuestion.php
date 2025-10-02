<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\QuestionType; 

class BuiltInQuestion extends Model
{
    
   protected $fillable = [
        'section_id',
        'question_type',
        'question_text',
        'question_options',
        'order',
        'source_table',
        'depends_on_question_id',
    ];

    protected $casts = [
        'question_options' => 'array',
        'question_type' => QuestionType::class,
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}


