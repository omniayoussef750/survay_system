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

        return response()->json(['message' => 'Project & surveys on this project deleted successfully']
        , 200);
    }
}
