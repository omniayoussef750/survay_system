<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $researcher = auth()->user();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        if (empty($validated['title'])) {
            $projectCount = Project::where('researcher_id', $researcher->id)->count() + 1;
            $validated['title'] = 'Project ' . $projectCount;
        }

        $project = Project::create(array_merge($validated, ['researcher_id' => $researcher->id]));

        return response()->json($project, 201);
    }
    public function getAllProjects(){

    $researcher = auth()->user();
    $projects = Project::where('researcher_id', $researcher->id)->get();

    if ($projects->isEmpty()) {
        return response()->json(['error'=>'You have not any projects yet'] , 404);
    }

    return response()->json($projects , 200);

}
    public function update(Request $request, $id)
    {
        $researcher = auth()->user();
        $project = Project::where('id', $id)->where('researcher_id', $researcher->id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $project->update($validated);

        return response()->json($project);
    }
    public function destroy($id)
    {
        $researcher = auth()->user();
        $project = Project::where('id', $id)->where('researcher_id', $researcher->id)->firstOrFail();

        $project->delete();
        $project->surveys()->delete();


        return response()->json(['message' => 'Project moved to recycle bin successfully']
        , 200);
    }
     public function forceDelete(Request $request)
{
    $validated = $request->validate([
        'ids' => 'required|array|min:1',
        'ids.*' => 'exists:projects,id',
    ]);

    $researcher = auth()->user();

    foreach ($validated['ids'] as $id){
       $project = Project::onlyTrashed()
            ->where('id', $id)
            ->where('researcher_id', $researcher->id)
            ->firstOrFail();

       $project->forceDelete();
    }

    return response()->json(['message' => 'Project permanently deleted successfully'], 200);
}

    public function getRecycleBin()
    {
        $researcher = auth()->user();

        $trashedProjects = Project::onlyTrashed()
            ->where('researcher_id', $researcher->id)
            ->get();

        return response()->json(['data' => $trashedProjects], 200);
    }
    public function restore($projectId)
{
    $researcher = auth()->user();

    $project = Project::onlyTrashed()
        ->where('id', $projectId)
        ->where('researcher_id', $researcher->id)
        ->firstOrFail();

    $project->restore();

    return response()->json(['message' => 'Project restored successfully',
'data' => $project,
], 200);
}
public function toggleFavoriteProject(Request $request ,$projectId){
 
    $validated = $request->validate([
      'is_favorite' => 'required|boolean',
    ]);

   $researcher = auth()->user();
   
   $project = Project::where('id' , $projectId)
   ->where('researcher_id' , $researcher->id)
   ->with('surveys')
   ->firstOrFail();

   $project->is_favorite = $validated['is_favorite'];
   $project->save();

  return response()->json(['message' => $project->is_favorite 
  ? 'Project marked as favorite' 
  : 'Project removed from favorites',
  'is_favorite' => $project->is_favorite,
  'project' => $project ]
  ,200);
}
public function getFavoriteProjects(){

$researcher = auth()->user();

$favoriteProjects = Project::where('researcher_id', $researcher->id)
->where('is_favorite' , true)->get();

  return response()->json(['message' => 'Favorite projects get successfully' , 
'data' => $favoriteProjects,
], 200);

}
}
