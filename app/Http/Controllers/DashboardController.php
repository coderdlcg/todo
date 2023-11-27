<?php

namespace App\Http\Controllers;

use App\Actions\getTaskListsByAuthUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(getTaskListsByAuthUserAction $getTaskListsByAuthUserAction)
    {
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'taskLists' => $getTaskListsByAuthUserAction()
        ]);
    }
}
