<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Note::truncate();
        $users = User::all();

        foreach ($users as $user) {
            Note::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
