<?php

namespace App\Http\Controllers\Tasks;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Tasks\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Projects\Project;
use App\Http\Controllers\Controller;
use App\Models\Projects\ProjectMember;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    try {
        $isAdmin = session('user')->access_type === 'Admin';
        $userIdnik = session('user')->idnik;

        if ($isAdmin) {
            $tasks = Task::with('project')->get();
            $totalTasks = Task::count();
            $pendingTasks = Task::where('status', 'Pending')->count();
            $completedTasks = Task::where('status', 'Completed')->count();
            $prosesTasks = Task::where('status', 'Progress')->count();
        } else {
            $tasks = Task::with('project')
            ->whereHas('project', function ($query) use ($userIdnik) {
                $query->whereHas('projectMembers', function ($memberQuery) use ($userIdnik) {
                    $memberQuery->where('idnik', $userIdnik);
                });
            })
            ->get();
        
        $totalTasks = $tasks->count();
        $pendingTasks = $tasks->where('status', 'Pending')->count();
        $completedTasks = $tasks->where('status', 'Completed')->count();
        $prosesTasks = $tasks->where('status', 'Progress')->count();
            
        
        }

        return view('task.task-list', compact('tasks', 'totalTasks', 'pendingTasks', 'prosesTasks', 'completedTasks'));
    } catch (\Exception $e) {
        Session::flash('error', 'Failed to load task list: ' . $e->getMessage());
        return redirect()->route('tasks.index');
    }
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        try {
            $isAdmin = session('user')->access_type === 'Admin';
        $userIdnik = session('user')->idnik;

        if($isAdmin){
            $projects = Project::get();
        }else{
            $projects = Project::where('idnik', session('user')->idnik)
    ->get(); 
        }

                return view('task.task-create', compact('projects'));
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to load create task form: ' . $e->getMessage());
            return redirect()->route('tasks.index');
        }
    }
    
    
    public function create(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required',
            'id_project' => 'required',
            'description' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'due_date' => 'required',
        ]);

        // Generate a unique task ID
        $currentDate = Carbon::now();
        $year = substr($currentDate->year, -2);
        $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
        $idTask = 'TSK' . $year . $currentDate->format('md') . substr(session('user')->idnik, -3) . $uuid;

        $task = new Task;
        $task->id_task = $idTask;
        $task->start_date = $request->start_date;
        $task->title = $request->title;
        $task->id_project = $request->id_project;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        Alert::success('Success', 'Task created successfully!');

        return redirect()->route('tasks.index');
    } catch (\Exception $e) {
        Alert::error('Error', 'Failed to create task. Please try again.');
        return redirect()->back();
    }
}
    public function view($id_task)
    {
        try {
            $task = Task::with('project')->find($id_task);

            if (!$task) {
                throw new \Exception('Task not found');
            }
            
            $projectMembers = ProjectMember::where('id_project', $task->id_project)->get();

        // Mengumpulkan idnik anggota proyek
        $idniks = $projectMembers->pluck('idnik')->toArray();

        // Mengambil data karyawan berdasarkan idnik anggota proyek
        $employees = Employee::whereIn('idnik', $idniks)->get();


            return view('task.task-view', compact('task', 'projectMembers', 'employees'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to view task. Please try again.' . $e->getMessage());
            return redirect()->route('tasks.index');
        }
    }

    public function edit($id_task)
    {
        try {
            $task = Task::find($id_task);

            if (!$task) {
                throw new \Exception('Task not found');
            }

            $projects = Project::with('projectMembers')
                ->whereHas('projectMembers', function ($query) {
                    $query->where('idnik', session('user')->idnik);
                })
                ->get();

            return view('task.task-edit', compact('projects', 'task'));
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to edit task: ' . $e->getMessage());
            return redirect()->route('tasks.index');
        }
    }

    public function update(Request $request, $id_task)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required',
                'id_project' => 'required',
                'description' => 'required',
                'status' => 'required',
                'due_date' => 'required',
                'start_date' => 'required',
            ]);

            $task = Task::find($id_task);

            if (!$task) {
                throw new \Exception('Task not found.');
            }

            $task->title = $request->title;
            $task->id_project = $request->id_project;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;
            $task->start_date = $request->start_date;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $id_task . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/tasks', $fileName);
                $task->file = $fileName;
            }

            $task->save();

            Alert::success('Success', 'Task updated successfully!');

            return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update task. Please try again.');
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id_task)
    {
        try {
            $task = Task::find($id_task);

            if ($task) {
                $task->delete();
                Alert::success('Success', 'Task deleted successfully!');
                return redirect()->route('tasks.index');
            } else {
                throw new \Exception('Task not found');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete task. Please try again.');
            return redirect()->route('tasks.index');
        }
    }
}
