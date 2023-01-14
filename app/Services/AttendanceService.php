<?php
namespace App\Services;

use App\Models\Employee;
use Carbon\Carbon;
use DateTime;

class AttendanceService
{
    public function get_employee_attendance($request, $employee_id)
    {
        if (!$employee_id) {
            abort(422, 'Employee Id is required');
        }
        if ($request->from && $request->to) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
        }else{
            $from = Carbon::now()->startOfDay();
            $to = Carbon::now()->endOfDay();
        }
        $emplyee_attendance = Employee::join('attendance', 'attendance.employee_id', 'employees.id')
                                        ->select(
                                            'attendance.*'
                                        )
                                        ->where('check_in', '>=', $from)
                                        ->where('attendance.employee_id', $employee_id)
                                        ->get();
        
        $total_working_hours = 0;
        
        foreach ($emplyee_attendance as $key => $attendance) {
            
            if ($attendance->check_in && $attendance->check_out) {
                $check_in = new DateTime($attendance->check_in);
                $check_out = new DateTime($attendance->check_out);
                $interval = $check_out->diff($check_in);

                $total_working_hours += $interval->h;

            }
            
        }

        return ['attendance' => $emplyee_attendance, 'total_hours' => $total_working_hours];
    }

    public function get_attendance_list($request)
    {
        if ($request->from && $request->to) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
        }else{
            $from = Carbon::now()->startOfDay();
            $to = Carbon::now()->endOfDay();
        }

        $attendance = Employee::join('attendance', 'attendance.employee_id', 'employees.id')
                            ->select(
                                'attendance.*',
                                'employees.name',
                            )
                            // ->where('check_in', '>=', $from)
                            // ->where('check_out', '<=', $to)
                            ->get();

        return $attendance;
    }
}