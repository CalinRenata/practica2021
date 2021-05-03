<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;


class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::create([
            'name' => 'Board1',
            'user' => 'Admin',
        ]);
    }
}
