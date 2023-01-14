<?php

namespace App\Imports;

use App\Models\Attendance;
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
        $date = $rows[0][1];
        if ($date === null) {
            abort(422,"Please Check the excel file");
        }
        $employee_key = 0;
        $employee_id_key = 0;
        $checking_key = 0;
        $checkout_key = 0;

        foreach ($rows[2] as $key => $col) {
            switch ($col) {
                case 'Employee Name':
                    $employee_key = $key;
                    break;
                case 'Employee ID':
                    $employee_id_key = $key;
                    break;
                case 'Check In':
                    $checking_key = $key;
                case 'Check Out':
                    $checkout_key = $key;
                    break;
                default:
                    abort(422,"Please Check the excel file");
                    break;
            }
        } 

        for ($i=3; $i < count($rows) ; $i++) { 
            $employee_id = $rows[$i][$employee_id_key];
            $employee_name = $rows[$i][$employee_key];
            $check_in = isset($rows[$i][$checking_key])?$this->formatTime($date, $rows[$i][$checking_key]): null;
            $check_out = isset($rows[$i][$checkout_key])? $this->formatTime($date, $rows[$i][$checkout_key]): null;

            $attendance = Attendance::where('employee_id', $employee_id)
                                    ->where('check_in', $check_in)
                                    ->where('check_out', $check_out)
                                    ->first();
            if (!$attendance) {
                $attendance = Attendance::create([
                    'employee_id' => $employee_id,
                    'schedule_id' => 0,
                    'check_in' => $check_in,
                    'check_out' => $check_out
                ]);
            }else{
                $attendance->check_in = $check_in;
                $attendance->check_out = $check_out;
                $attendance->save();
            }

        }
    }

    public function startRow() :int
    {
        return 2;
    }

    private function formatTime($date,$time_string)
    {
        
        $formated_time = Carbon::createFromFormat("d/m/Y H:i:s",$date." ".$time_string);

         return $formated_time;
    }
}
