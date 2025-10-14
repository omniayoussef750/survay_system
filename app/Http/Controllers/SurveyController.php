<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Project;

class SurveyController extends Controller
{
    public function store(Request $request)
    {
        $researcher = auth()->user();

        $validated = $request->validate([
            'project_id' =>'sometimes|nullable|exists:projects,id',
            'title' => 'nullable|string|max:255',
            'description' =>'nullable|string'
        ]);

        $projectId = $validated['project_id'] ?? null;

        if (empty($validated['title'])) {
           $surveyCount = Survey::when($projectId, function ($query) use ($projectId) {
                return $query->where('project_id', $projectId);
           }, function ($query) {

            return $query->where('researcher_id',$researcher_id)->whereNull('project_id');
        })
        ->count() + 1;

        $validated['title'] = $projectId
            ? 'Survey ' . $surveyCount
            : 'Survey ' . $surveyCount;
        }
        // Create survey depending on whether project_id exists
         if ($projectId) {
        // ensure project belongs to this researcher
        $project = Project::where('id', $projectId)
            ->where('researcher_id', $researcher->id)
            ->firstOrFail();

         $survey = $project->surveys()->create(array_merge(
            $validated,
            ['researcher_id' => $researcher->id]
        ));
    } else {
        // create standalone survey (no project)
        $survey = Survey::create(array_merge(
            $validated,
            [
                'researcher_id' => $researcher->id,
                'project_id' => null,
            ]
        ));
    }
        return response()->json($survey, 201);
}
public function getAllSurveys(){

    $researcher = auth()->user();
    $surveys = Survey::where('researcher_id', $researcher->id)->get();

    if ($surveys->isEmpty()) {
        return response()->json(['error'=>'You have not any surveys yet'] , 404);
    }

    return response()->json($surveys , 200);

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

        return response()->json(['message' => 'Survey moved to recycle bin successfully']
        , 200);
    }
   public function forceDelete(Request $request)
{
    $validated = $request->validate([
        'ids' => 'required|array|min:1',
        'ids.*' => 'exists:surveys,id',
    ]);

    $researcher = auth()->user();

    foreach ($validated['ids'] as $id){
       $survey = Survey::onlyTrashed()
            ->where('id', $id)
            ->where('researcher_id', $researcher->id)
            ->firstOrFail();

       $survey->forceDelete();
    }

    return response()->json(['message' => 'Survey permanently deleted successfully'], 200);
}
    public function getRecycleBin()
    {
        $researcher = auth()->user();

        $trashedSurveys = Survey::onlyTrashed()
            ->where('researcher_id', $researcher->id)
            ->get();

        return response()->json($trashedSurveys, 200);
    }
     public function restore($surveyId)
{
    $researcher = auth()->user();

    $survey = Survey::onlyTrashed()
        ->where('id', $surveyId)
        ->where('researcher_id', $researcher->id)
        ->firstOrFail();

    $survey->restore();

    return response()->json(['message' => 'Project restored successfully' , 
'data' => $survey,
], 200);
}

public function toggleFavoriteSurvey(Request $request ,$surveyId){
 
    $validated = $request->validate([
      'is_favorite' => 'required|boolean',
    ]);

   $researcher = auth()->user();
   
   $survey = Survey::where('id' , $surveyId)
   ->where('researcher_id' , $researcher->id)
   ->firstOrFail();

   $survey->is_favorite = $validated['is_favorite'];
   $survey->save();

  return response()->json(['message' => $survey->is_favorite 
  ? 'Survey marked as favorite' 
  : 'Survey removed from favorites',
  'is_favorite' => $survey->is_favorite,
  'survey' => $survey]
  ,200);
}
public function getFavoriteSurveys(){

$researcher = auth()->user();

$favoriteSurveys = Survey::where('researcher_id', $researcher->id)
->where('is_favorite' , true)->get();

  return response()->json(['message' => 'Favorite surveys get successfully' , 
'data' => $favoriteSurveys,
], 200);

}
}
