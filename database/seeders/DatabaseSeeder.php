<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
         'name' => 'Test User',
         'email' => 'asd@asd.com',
         'password' => Hash::make('asdfasdf')
        ]);

        $home = $user->taskLists()->create([
            'user_id' => $user->id,
            'title' => 'Home',
        ]);

        $home->tasks()->create([
            'title' => 'Do some general cleaning'
        ]);

        $learn = $user->taskLists()->create([
            'user_id' => $user->id,
            'title' => 'Learn',
        ]);

        $learn->tasks()->create([
            'title' => 'Read a book on PHP programming'
        ]);

        $job = $user->taskLists()->create([
            'user_id' => $user->id,
            'title' => 'Job',
        ]);

        $job->tasks()->create([
            'title' => 'Implementation self web site portfolio'
        ]);

        $moto = $user->taskLists()->create([
            'user_id' => $user->id,
            'title' => 'Moto',
        ]);

        $moto->tasks()->create([
            'title' => 'Find tyres for new season'
        ]);
    }
}
