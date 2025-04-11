<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardianUser = User::where('email', 'parent@example.com')->first();

        Guardian::create([
            'user_id' => $guardianUser->id,
            'name' => 'Test Parent',
            'email' => 'parent@example.com',
            'phone' => '123-456-7890',
        ]);
    }
}
