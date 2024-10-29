<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Employee;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->count(5)->create()->each(function ($project) {
            $employees = Employee::inRandomOrder()->take(rand(3, 5))->get();
            foreach ($employees as $employee) {
                $project->employees()->attach($employee->id, [
                    'role' => $this->getRandomRole(),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            }
        });
    }

    private function getRandomRole()
    {
        $roles = ['Developer', 'Designer', 'Manager', 'Tester'];
        return $roles[array_rand($roles)];
    }
}
