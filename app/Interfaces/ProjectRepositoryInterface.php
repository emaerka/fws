<?php

namespace App\Interfaces;

use App\Models\Project;
use Illuminate\Http\Request;

interface ProjectRepositoryInterface {
    public function getProjectsForList(Request $request);
    public function storeProject(array $projectDetails);
    public function updateProject(Project $project, array $projectDetails);
    public function deleteProject(Project $project);
}

?>