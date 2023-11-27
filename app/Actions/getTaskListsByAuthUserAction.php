<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class getTaskListsByAuthUserAction
{

    public function __invoke(): ?Collection
    {
        try {
            return auth()->user()?->taskLists;
        } catch (\Exception $e) {
            Log::error('Exception getTaskListsByAuthUserAction __invoke(): ' . $e->getMessage());

            return null;
        }
    }
}
