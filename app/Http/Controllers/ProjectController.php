<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Projects\Project;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Projects\ProjectMember;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $divisi = session('user')->divisi;
            $users = Employee::where('divisi', $divisi)->get();
            return view('project.index', ['users' => $users]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Session::flash('error', $errorMessage);
            return redirect()->back();
        }
        return view('project.index', ['users' => $users]);
    }

    public function show(Request $request)
{
    try {
        $perPage = 8;
        $query = Project::query();
        $search = $request->input('search');
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $statusFilter = $request->input('status_filter');
        if ($statusFilter && $statusFilter != 'All') {
            $query->where('status', $statusFilter);
        }

    $query->orderByRaw("FIELD(status, 'Open', 'On Progress', 'Closed', 'Canceled')");

        $query->whereIn('id_project', function ($subquery) {
            $subquery->select('id_project')
                ->from('project_member')
                ->where('idnik', session('user')->idnik);
        });

        $query->withCount('tasks');

        $projectPage = $query->paginate($perPage);
        $projects = $projectPage->items();

        $members = DB::table('project_member')
            ->join('user', 'project_member.idnik', '=', 'user.idnik')
            ->select('project_member.*', 'user.*')
            ->get();

        foreach ($projects as $project) {
            $project->completedTasksCount = $project->tasks()->where('status', 'completed')->count();
            $project->totalTasksCount = $project->tasks_count;
            $project->progressPercentage = $project->totalTasksCount > 0 ? ($project->completedTasksCount / $project->totalTasksCount) * 100 : 0;
        }

        return view('project.project-list', ['projects' => $projects, 'members' => $members, 'projectPage' => $projectPage]);
    } catch (\Exception $e) {
        $errorMessage = $e->getMessage();
        Session::flash('error', $errorMessage);
        return redirect()->back();
    }
}



    public function view($id)
    {
        try {
            $project = Project::find($id);

            if (!$project) {
                return redirect()->back()->with('error', 'Project not found.');
            }

            $projectFiles = $project->file;

            $taskFiles = DB::table('project')
                ->join('task', 'project.id_project', '=', 'task.id_project')
                ->where('project.id_project', $id)
                ->select('project.*', 'task.*')
                ->get();

            $taskList = DB::table('task')
                ->join('user', 'task.idnik', '=', 'user.idnik')
                ->where('task.id_project', $id)
                ->select('task.*', 'user.nama')
                ->get();

            $members = DB::table('project_member')
                ->join('user', 'project_member.idnik', '=', 'user.idnik')
                ->select('project_member.*', 'user.*')
                ->get();

            return view('project.project-view', ['project' => $project, 'projectFiles' => $projectFiles, 'taskFiles' => $taskFiles, 'members' => $members, 'taskList' => $taskList]);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
            'due_date' => 'required|date|after_or_equal:start_date',
            'start_date' => 'required|date|before_or_equal:due_date',
            'categories' => 'required',
            'memberIds' => 'required',
        ]);

        $generatedId = false;
        $idProject = '';

        while (!$generatedId) {
            $currentDate = Carbon::now();
            $year = substr($currentDate->year, -2);
            $idnik = session('user')->idnik;
            $generatedUuid = Str::uuid();
            $parts = explode("-", $generatedUuid);
            $numericUuid = implode("", array_filter($parts, 'is_numeric'));
            $uuid = substr($numericUuid, 0, 3);
            $uuid = sprintf('%03d', $uuid);
            $idProject = 'PJT' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

            $existingProject = Project::where('id_project', $idProject)->first();

            if (!$existingProject) {
                $generatedId = true;
            }
        }

        $project = new Project();

        if ($file = $request->file('file')) {
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = $idProject . '.' . $fileExtension;
            $filePath = $file->storeAs('public/projects', $fileName);
            $fileUrl = Storage::url($filePath);
            $project->file = $fileName;
        } else {
            $fileUrl = null;
        }

        $project->id_project = $idProject;
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->status = $request->input('status');
        $project->categories = $request->input('categories');
        $project->idnik = session('user')->idnik;
        $project->start_date = $request->input('start_date');
        $project->due_date = $request->input('due_date');
        $project->save();

        $memberIdsArray = explode(',', $request->input('memberIds')[0]);

        foreach ($memberIdsArray as $idnik) {
            $lastFourDigitsOfIdnik = substr($idnik, -4);
            $randomDigits = str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
            $projectMemberId = 'PM' . $lastFourDigitsOfIdnik . $randomDigits;

            $projectMember = new ProjectMember();
            $projectMember->id_project_member = $projectMemberId;
            $projectMember->id_project = $idProject;
            $projectMember->idnik = $idnik;

            $projectMember->save();
        }

        Alert::success('Success', 'Project created successfully!');

        return redirect()->route('projects.show');
    } catch (ValidationException $e) {
        Alert::error('Error', 'Failed to create project. Check your input.');
       return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        Alert::error('Error', 'Failed to create project. Please try again.');
        return redirect()->back();
    }
}

    public function edit($id)
    {
        try {
            $divisi = session('user')->divisi;
            $project = Project::findOrFail($id);
            $users = Employee::where('divisi', $divisi)->get();

            $selectedUsers = DB::table('project_member')
                ->join('user', 'project_member.idnik', '=', 'user.idnik')
                ->where('project_member.id_project', $id)
                ->select('user.*')
                ->get();

            return view('project.project-edit', ['project' => $project, 'users' => $users, 'selectedUsers' => $selectedUsers]);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'status' => 'required',
                'due_date' => 'required|date',
                'start_date' => 'required|date',
                'categories' => 'nullable',
                'selectedMembers' => 'nullable|array',
                'file' => 'nullable|file',
            ]);

            $project = Project::findOrFail($id);

            $project->title = $request->input('title');
            $project->description = $request->input('description');
            $project->status = $request->input('status');
            $project->due_date = $request->input('due_date');
            $project->start_date = $request->input('start_date');
            $project->categories = $request->input('categories');

            $fileUrl = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = $id . '.' . $fileExtension;
                $filePath = $file->storeAs('public/projects', $fileName);
                $fileUrl = Storage::url($filePath);

                if ($project->file) {
                    Storage::delete('public/projects/' . $project->file);
                }

                $project->file = $fileName;
            }

            $project->save();

            $selectedMembers = $request->input('selectedMembers', []);
            $selectedMembersString = implode(',', $selectedMembers);
            $memberIdsArray = explode(',', $selectedMembersString);

            ProjectMember::where('id_project', $id)->delete();

            foreach ($memberIdsArray as $idnik) {
                $lastFourDigitsOfIdnik = substr($idnik, -4);
                $randomDigits = str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
                $projectMemberId = 'PM' . $lastFourDigitsOfIdnik . $randomDigits;

                $projectMember = new ProjectMember();
                $projectMember->id_project_member = $projectMemberId;
                $projectMember->id_project = $id;
                $projectMember->idnik = $idnik;
                $projectMember->save();
            }
            Alert::success('Success', 'Project updated successfully!');
            return redirect()->route('projects.show', $project->id);
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update project. Please try again.');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            DB::table('project_member')->where('id_project', $id)->delete();

            Alert::success('Success', 'Project deleted successfully!');
            return redirect()->route('projects.show');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete project. Please try again.');
            return redirect()->route('projects.show');
        }
    }
}
