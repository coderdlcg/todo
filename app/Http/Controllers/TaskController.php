<?php

namespace App\Http\Controllers;

use App\Actions\getTaskListsByAuthUserAction;
use App\Actions\TaskSwitcherStatusAction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct( private getTaskListsByAuthUserAction $getTaskListsByAuthUserAction )
    {
    }

    public function create($taskListId)
    {
        return Inertia::render('Tasks/Create', [
            'taskLists' => ($this->getTaskListsByAuthUserAction)(),
            'taskListId' => $taskListId
        ]);
    }

    public function show(string $id)
    {
        $task = Task::query()->find($id);

        if ($task?->list?->user_id !== auth()->user()?->id) {
            abort(404);
        }

        $taskLists = ($this->getTaskListsByAuthUserAction)();

        return Inertia::render('Tasks/Show', [
            'taskLists' => $taskLists,
            'task' => $task,
        ]);
    }

    public function edit(string $id)
    {
        $task = Task::query()->find($id);

        if ($task?->list?->user_id !== auth()->user()?->id) {
            abort(404);
        }

        $taskLists = ($this->getTaskListsByAuthUserAction)();

        return Inertia::render('Tasks/Edit', [
            'taskLists' => $taskLists,
            'task' => $task,
        ]);
    }

    public function done(string $id, TaskSwitcherStatusAction $taskSwitcherStatusAction)
    {
        $task = Task::query()->find($id);

        if ($task?->list?->user_id !== auth()->user()?->id) {
            abort(404);
        }

        $taskSwitcherStatusAction($task);

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:190'],
        ]);

        try {
            $task = Task::query()->find($id);

            if ($task?->list?->user_id !== auth()->user()?->id) {
                abort(404);
            }

            $task->update([
                'title' => $validated['title']
            ]);

            return redirect()->route('tasks.show', $task->id);

        } catch (\Exception $e) {
            Log::error('Exception TaskController update(): ' . $e->getMessage(), [$request->all()]);

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:190'],
            'taskListId' => ['required', 'numeric'],
        ]);

        try {
            $taskList = auth()->user()?->taskLists()->find($validated['taskListId']);

            $taskList?->tasks()->create([
                'title' => $validated['title']
            ]);

            return redirect()->route('task-lists.show', $taskList->id);

        } catch (\Exception $e) {
            Log::error('Exception TaskController store(): ' . $e->getMessage(), [$request->all()]);

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $task = Task::query()->find($id);

            $taskList = $task?->list;

            if ($taskList?->user_id === auth()->user()?->id) {
                $task->delete();
            }
        } catch (\Exception $e) {
            Log::error('Exception TaskController destroy(): ' . $e->getMessage(), ['id' => $id]);
        }

        return redirect()->route('task-lists.show', $taskList->id);
    }
}
