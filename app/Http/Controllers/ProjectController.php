<?php

namespace App\Http\Controllers;

use App\Enums\Project\Status;
use App\Http\Requests\Project\CreateRequest;
use App\Http\Resources\ContactPeople\IndexResource;
use App\Http\Resources\Project\IndexResource as ProjectIndexResource;
use App\Http\Resources\Project\ShowResource;
use App\Interfaces\ProjectRepositoryInterface;
use App\Models\ContactPerson;
use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index()
    {
        $project = $this->projectRepository->getProjectsForList();

        return Inertia::render('Task/Index', [
            'projects' => ProjectIndexResource::collection($project),
        ]);
    }

    public function create()
    {
        $contactPeople = ContactPerson::orderBy('name', 'asc')->get();

        return Inertia::render('Task/Show', [
            'contactPeople' => IndexResource::collection($contactPeople),
            'status' => Arr::map(Status::cases(), function ($e, $key) {
                return ['name' => __('common.project.status.' . $e->value), 'value' => $e->value];
            }),
        ]);
    }


    public function store(CreateRequest $request)
    {
        $this->projectRepository->storeProject($request->all());

        return redirect()->back()->with('success', 'A projekt létrehozása sikeres!');
    }

    public function show(Project $project)
    {
        $project->load('contactPeople');
        $contactPeople = ContactPerson::orderBy('name', 'asc')->get();
        return Inertia::render('Task/Show', [
            'project' => ShowResource::make($project),
            'contactPeople' => IndexResource::collection($contactPeople),
            'status' => Arr::map(Status::cases(), function ($e, $key) {
                return ['name' => __('common.project.status.' . $e->value), 'value' => $e->value];
            }),
        ]);
    }


    public function update(Project $project, CreateRequest $request)
    {
        $this->projectRepository->updateProject($project, $request->all());

        return redirect()->back()->with('success', 'The project saved successfully!');
    }

    public function delete(Project $project)
    {
        $this->projectRepository->deleteProject($project);
        return redirect()->back()->with('success', 'The project saved successfully!');
    }
}
