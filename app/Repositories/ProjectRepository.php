<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface {
    
    public function getProjectsForList()
    {
        return Project::withCount('contactPeople')
        ->paginate(config('settings.pagination'));
    }

    public function storeProject(array $projectDetails)
    {
        $project = Project::create([
            'name' => $projectDetails['name'],
            'description' => $projectDetails['description'],
            'status' => $projectDetails['status'],
        ]);

        $project->contactPeople()->sync($projectDetails['contact_people']);
    }

    public function updateProject(Project $project, array $projectDetails)
    {
        $project->update($projectDetails);

        $project->contactPeople()->sync($projectDetails['contact_people']);
    }

    public function deleteProject(Project $project)
    {
        $project->contactPeople()->sync([]);
        $project->delete();
    }
}
