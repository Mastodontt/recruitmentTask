<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskDestroyRequest;
use App\Http\Requests\TaskEditRequest;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(TaskIndexRequest $request): View
    {
        $tasks = $request->filter()->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create(TaskCreateRequest $request): View
    {
        return view('tasks.create');
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        try {
            $task = Task::createIt(
                $request->getName(),
                $request->getDescription(),
                $request->getPriority(),
                $request->getStatus(),
                $request->getDueDate()
            );
            $task->saveOrFail();
        } catch (\Throwable $exception) {
            Log::error('Failure to save task: '.$exception->getMessage());

            return redirect()->back()->with('error', 'An error occured while creating task.');
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(TaskEditRequest $request, Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        try {
            $task->setName($request->getName());
            $task->setDescription($request->getDescription());
            $task->setPriority($request->getPriority());
            $task->setTaskStatus($request->getStatus());
            $task->setDueDate($request->getDueDate());
            $task->saveOrFail();
        } catch (\Throwable $exception) {
            Log::error('Failure to update task: '.$exception->getMessage());

            return redirect()->back()->with('error', 'An error occured while updating task.');
        }

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(TaskDestroyRequest $request, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
