<?php

namespace Database\Seeders;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::truncate();

        $shifts = [
            [
                'id' => 1,
                'name' => 'Day',
                'start_time' => $this->formatTime("09:00:00"),
                'end_time' => $this->formatTime("15:00:00"),
            ],
            [
                'id' => 2,
                'name' => 'Evening',
                'start_time' => $this->formatTime("15:01:00"),
                'end_time' => $this->formatTime("21:00:00"),
            ],
            [
                'id' => 3,
                'name' => 'Night',
                'start_time' => $this->formatTime("21:01:00"),
                'end_time' => $this->formatTime("03:00:00"),
            ],
            
        ];

        DB::table('shifts')->insert($shifts);
    }

    private function formatTime($time_string)
    {
        
        $formated_time = Carbon::createFromFormat("H:i:s",$time_string);

         return $formated_time;
    }
}
