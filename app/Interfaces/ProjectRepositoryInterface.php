<?php

namespace App\Interfaces;

use App\Models\Project;

interface ProjectRepositoryInterface {
    public function getProjectsForList();
    public function storeProject(array $projectDetails);
    public function updateProject(Project $project, array $projectDetails);
    public function deleteProject(Project $project);
}

?>