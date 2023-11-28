<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class getTaskListsByAuthUserAction
{

    public function __invoke(): ?Collection
    {
        return auth()->user()?->taskLists()->select('id', 'title')->with('tasks')->get();
    }
}
