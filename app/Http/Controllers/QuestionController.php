<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuiltInQuestion;
use App\Models\Section;
use App\Enums\QuestionType;
use App\Models\AllQuestion;
use App\Models\AllQuestionSection;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function getBuiltInQuestions(Request $request)
    {
      $builtInQuestions = BuiltInQuestion::with('section')->get();
          return response()->json($builtInQuestions);
    
    }
    public function getQuestionsBySection($sectionId)
    {
        $questions = BuiltInQuestion::where('section_id', $sectionId)->get();
        return response()->json($questions);
    }
    public function getSections()
    {
        $sections = Section::all();
        return response()->json($sections);
    }
    public function getQuestionTypes(){
        $questionTypes = QuestionType::options();
        return response()->json($questionTypes);
    }
    public function addQuestions(Request $request ,$surveyId)
    {
         $validated = $request->validate([

        'sections' => 'required|array',
        'sections.*.name' => 'required|string',
        'sections.*.order' => 'required|integer',
        'sections.*.questions' => 'required|array',
        'sections.*.questions.*.question_text' => 'required|string',
        'sections.*.questions.*.question_type' => 'required|string',
        'sections.*.questions.*.question_options' => 'nullable|array',
        'sections.*.questions.*.order' => 'required|integer',
    ]);

       DB::transaction(function () use ($validated, $surveyId) {
        // Step 1: Clear old sections & questions
        // AllQuestionSection::where('survey_id', $surveyId)->delete();
        // AllQuestion::where('survey_id', $surveyId)->delete();

        // Step 2: Recreate survey_sections and all_questions
        foreach ($validated['sections'] as $sectionData) {
             $section = AllQuestionSection::where('survey_id', $surveyId)
                ->where('name', $sectionData['name'])
                ->first();

            if ($section) {
                return response()->json([
            'message' => 'Section names must be unique within a survey.',
        ], 422);
            }
            $section = AllQuestionSection::create([
                'survey_id' => $surveyId,
                'name' => $sectionData['name'],
                'order' => $sectionData['order'],
            ]);

            foreach ($sectionData['questions'] as $q) {
                 AllQuestion::create([
                    'survey_id' => $surveyId,
                    'section_id' => $section->id,
                    'question_text' => $q['question_text'],
                    'question_type' => $q['question_type'],
                    'question_options' => isset($q['question_options']) && is_array($q['question_options'])? $q['question_options']: null,
                    'order' => $q['order'],
                ]);
            }
        }
    });

    $allQuestions = AllQuestion::where('survey_id', $surveyId)->get();
    
    return response()->json(['message' => 'Survey structure saved successfully',
    'all_questions' => $allQuestions,
    ], 200);
}
}
