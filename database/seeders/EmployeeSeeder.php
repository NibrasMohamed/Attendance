<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::insert(
            [
                'id' => 1,
                'name' => 'Nibras',
            ],
            [
                'id' => 2,
                'name' => 'Jhon',
            ],
            [
                'id' => 3,
                'name' => 'Joe',
            ],
            [
                'id' => 4,
                'name' => 'Malcom',
            ],
            [
                'id' => 5,
                'name' => 'Bob',
            ],
            [
                'id' => 6,
                'name' => 'Tiffany',
            ],
            [
                'id' => 7,
                'name' => 'Shelby',
            ],
            [
                'id' => 8,
                'name'=> 'tommy'
            ],
            [
                'id' => 9,
                'name' => 'Bill'
            ]
        );
    }
}
