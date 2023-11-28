<?php

namespace App\Actions;

class TaskSwitcherStatusAction
{
    public function __invoke($task): void
    {
        if ($task->is_done) {
            $task->is_done = false;
        } else {
            $task->is_done = true;
        }

        $task->save();
    }
}
