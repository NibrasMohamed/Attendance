<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class attendanceImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        for ($i=3; $i < count($rows) ; $i++) { 
            
            dd($this->formatTime($rows[$i][2]));

        }
    }

    public function startRow() :int
    {
        return 2;
    }

    private function formatTime($time_string)
    {
         $formated_time = Carbon::createFromFormat("H:i:s", $time_string);

         return $formated_time;
    }
}
