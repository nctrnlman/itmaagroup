<?php

namespace App\Http\Controllers\Tasks;

use Carbon\Carbon;
use App\Models\Tasks\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Projects\Project;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


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
            $userIdnik = session('user')->idnik;
            $tasks = Task::with('project')->where('idnik', $userIdnik)->get();
            $totalTasks = Task::where('idnik', $userIdnik)->count();
            $pendingTasks = Task::where('idnik', $userIdnik)->where('status', 'Pending')->count();
            $completedTasks = Task::where('idnik', $userIdnik)->where('status', 'Completed')->count();
            $prosesTasks = Task::where('idnik', $userIdnik)->where('status', 'Progress')->count();

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
            $projects = Project::with('projectMembers')
                ->whereHas('projectMembers', function ($query) {
                    $query->where('idnik', session('user')->idnik);
                })
                ->get();

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
                'due_date' => 'required',
            ]);

            $generatedId = false;
            $idTask = '';

            while (!$generatedId) {
                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik = session('user')->idnik;
                $generatedUuid = Str::uuid();
                $parts = explode("-", $generatedUuid);
                $numericUuid = implode("", array_filter($parts, 'is_numeric'));
                $uuid = substr($numericUuid, 0, 3);
                $idTask = 'TSK' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = Task::where('id_task', $idTask)->first();

                if (!$existingTask) {

                    $generatedId = true;
                }
            }

            $task = new Task;
            $task->id_task = $idTask;
            $task->idnik = $idnik;
            $task->create_date = $currentDate;
            $task->title = $request->title;
            $task->id_project = $request->id_project;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;
            $task->save();

            Session::flash('success', 'Task created successfully.');

            return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to create task. Please try again.');

            return redirect()->route('tasks.index');
        }
    }

    public function view($id_task)
    {
        try {
            $task = Task::with('project')->find($id_task);

            if (!$task) {
                throw new \Exception('Task not found');
            }

            return view('task.task-view', compact('task'));
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to view task: ' . $e->getMessage());
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

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $id_task . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/uploads/tasks', $fileName);
                $task->file = $fileName;
            }

            $task->save();

            Session::flash('success', 'Task updated successfully.');

            return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to update task. Please try again.');

            return redirect()->route('tasks.index');
        }
    }

    public function delete(Request $request, $id_task)
    {
        try {
            $task = Task::find($id_task);

            if ($task) {
                $task->delete();

                return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
            } else {
                throw new \Exception('Task not found');
            }
        } catch (\Exception $e) {
            $errorMessage = 'Failed to delete task. Please try again.';

            return redirect()->route('tasks.index')->with('error', $errorMessage);
        }
    }
}
