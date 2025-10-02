<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Project;

class SurveyController extends Controller
{
    public function store(Request $request ,$projectId)
    {
          $researcher = auth()->user();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
        ]);
        if (empty($validated['title'])) {
            $surveyCount = Survey::where('project_id', $projectId)->count() + 1;
            $validated['title'] = 'Survey ' . $surveyCount;
        }

        $project = Project::findOrFail($projectId);
        $survey = $project->surveys()->create(array_merge($validated, ['researcher_id' => $researcher->id]));

        return response()->json($survey, 201);
    }
    public function update(Request $request , $surveyId)
    {
        $researcher = auth()->user();
        $survey = Survey::where('id', $surveyId)->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
        ]);

        $survey->update($validated);

        return response()->json($survey);
    }
    public function destroy($surveyId)
    {
        $researcher = auth()->user();
        $survey = Survey::where('id', $surveyId)->firstOrFail();

        $survey->delete();

        return response()->json(['message' => 'Survey deleted successfully']
        , 200);
    }
}
