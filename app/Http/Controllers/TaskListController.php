<?php

namespace App\Http\Controllers;

use App\Actions\getTaskListsByAuthUserAction;
use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TaskListController extends Controller
{
    public function __construct( private getTaskListsByAuthUserAction $getTaskListsByAuthUserAction )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('TaskLists/Index', [
            'taskLists' => ($this->getTaskListsByAuthUserAction)()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TaskLists/Create', [
            'taskLists' => ($this->getTaskListsByAuthUserAction)()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:190'],
        ]);

        try {
            $taskList = auth()->user()?->taskLists()->create([
                'title' => $validated['title']
            ]);

            return redirect()->route('task-lists.show', $taskList->id);

        } catch (\Exception $e) {
            Log::error('Exception TaskListController store(): ' . $e->getMessage(), [$request->all()]);

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $taskLists = ($this->getTaskListsByAuthUserAction)();
        $taskList = $taskLists->filter(fn($taskList) => $taskList->id === (int) $id)->first();

        if (!$taskList) {
            abort(404);
        }

        $taskList->load('tasks');

        return Inertia::render('TaskLists/Show', [
            'taskLists' => $taskLists,
            'taskList' => $taskList,
            'tasks' => $taskList->tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $taskLists = ($this->getTaskListsByAuthUserAction)();
        $taskList = $taskLists->filter(fn($taskList) => $taskList->id === (int) $id)->first();

        if (!$taskList) {
            abort(404);
        }

        return Inertia::render('TaskLists/Edit', [
            'taskLists' => $taskLists,
            'taskList' => $taskList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:18'],
        ]);

        try {
            $taskList = auth()->user()?->taskLists()
                ->find($id)
                ?->update([
                    'title' => $validated['title']
                ]);

            return redirect()->route('task-lists.show', $taskList->id);

        } catch (\Exception $e) {
            Log::error('Exception TaskListController update(): ' . $e->getMessage(), [$request->all()]);

            return redirect()->route('task-lists.show', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            auth()->user()?->taskLists()->find($id)?->delete();

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Exception TaskListController destroy(): ' . $e->getMessage(), ['id' => $id]);

            return redirect()->back();
        }
    }
}
