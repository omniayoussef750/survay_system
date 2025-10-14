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
      $builtInQuestions = BuiltInQuestion::with('section')->paginate(4);
          return response()->json($builtInQuestions);
    
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getQuestionsBySection($sectionId)
    {
        $questions = BuiltInQuestion::where('section_id', $sectionId)->paginate(4);
        return response()->json($questions);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function getSections()
    {
        $sections = Section::all();
        return response()->json($sections);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function getQuestionTypes(){
        $questionTypes = QuestionType::options();
        return response()->json($questionTypes);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function addBuiltInQuestionsToSurvey(Request $request, $surveyId)
{
    $validated = $request->validate([
        'built_in_question_ids' => 'required|array',
        'built_in_question_ids.*' => 'exists:built_in_questions,id',
    ]);

       $allQuestions = [];

        foreach ($validated['built_in_question_ids'] as $biqId) {
            $biq = BuiltInQuestion::findOrFail($biqId);

            $existingQuestion = AllQuestion::where('survey_id', $surveyId)
                ->where('question_text', $biq->question_text)
                ->exists();

            if ($existingQuestion) {
                return response()->json([
            'message' => 'This Question already exists in your survey.',
        ], 422);
            }
           $allQuestions[] = AllQuestion::create([
                'survey_id' => $surveyId,
                'question_text' => $biq->question_text,
                'question_type' => $biq->question_type,
                'question_options' => $biq->question_options,
                'order' => $biq->order,
            ]);
        }

     return response()->json(['message' => 'Questions added to your survey',
    'all_questions' => $allQuestions,
    ], 201);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function editQuestion(Request $request ,$surveyId , $questionId)
    {
         $validated = $request->validate([

        'question_text' => 'sometimes|required|string',
        'question_type' => 'sometimes|required|string',
        'question_options' => 'sometimes|nullable|array',
        'order' => 'sometimes|required|integer',

        'section_name' => 'sometimes|required|string',
        'section_order' => 'sometimes|required|integer',
    ]);
    
    $question = AllQuestion::where('survey_id', $surveyId)
        ->where('id', $questionId)
        ->firstOrFail();

         if (isset($validated['section_name'])) {
        $section = AllQuestionSection::firstOrCreate(
            [
                'survey_id' => $surveyId,
                'name' => $validated['section_name'],
            ],
            [
                'order' => $validated['section_order'] ?? 0,
            ]
        );
         $question->section_id = $section->id;
    }
    if (isset($validated['question_options'])) {
        $validated['question_options'] = json_encode($validated['question_options']);
    }       
        $question->update($validated);

        return response()->json([
        'message' => 'تم تعديل السؤال وربطه بالسكشن بنجاح',
        'question' => $question->load('section')
    ]);

}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function getQuestionsBySurvey($surveyId)
{
    $questions = AllQuestion::where('survey_id', $surveyId)->with('section')->get();
    return response()->json($questions);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//     public function addQuestions(Request $request ,$surveyId)
//     {
//          $validated = $request->validate([

//         'sections' => 'required|array',
//         'sections.*.name' => 'required|string',
//         'sections.*.order' => 'required|integer',
//         'sections.*.questions' => 'required|array',
//         'sections.*.questions.*.question_text' => 'required|string',
//         'sections.*.questions.*.question_type' => 'required|string',
//         'sections.*.questions.*.question_options' => 'nullable|array',
//         'sections.*.questions.*.order' => 'required|integer',
//     ]);

//        DB::transaction(function () use ($validated, $surveyId) {
//         // Step 1: Clear old sections & questions
//         AllQuestionSection::where('survey_id', $surveyId)->delete();
//         AllQuestion::where('survey_id', $surveyId)->delete();

//         // Step 2: Recreate survey_sections and all_questions
//         foreach ($validated['sections'] as $sectionData) {
//              $section = AllQuestionSection::where('survey_id', $surveyId)
//                 ->where('name', $sectionData['name'])
//                 ->first();

//             if ($section) {
//                 return response()->json([
//             'message' => 'Section names must be unique within a survey.',
//         ], 422);
//             }
//             $section = AllQuestionSection::create([
//                 'survey_id' => $surveyId,
//                 'name' => $sectionData['name'],
//                 'order' => $sectionData['order'],
//             ]);

//             foreach ($sectionData['questions'] as $q) {
//                  AllQuestion::create([
//                     'survey_id' => $surveyId,
//                     'section_id' => $section->id,
//                     'question_text' => $q['question_text'],
//                     'question_type' => $q['question_type'],
//                     'question_options' => isset($q['question_options']) && is_array($q['question_options'])? $q['question_options']: null,
//                     'order' => $q['order'],
//                 ]);
//             }
//         }
//     });

//     $allQuestions = AllQuestion::where('survey_id', $surveyId)->get();
    
//     return response()->json(['message' => 'Survey structure saved successfully',
//     'all_questions' => $allQuestions,
//     ], 200);
// }
}
