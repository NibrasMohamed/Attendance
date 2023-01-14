<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\getAtendanceRequest;
use App\Http\Requests\getAttendanceList;
use App\Http\Requests\getAttendanceListRequest;
use App\Http\Requests\getEmployeeAtendanceRequest;
use App\Http\Requests\UploadExcelRequest;
use App\Imports\attendanceImport;
use App\Models\Employee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Excel;
use Exception;

class AttendanceController extends Controller
{
    public function uploadExcel(UploadExcelRequest $request)
    {
        try {
            $excel_import = Excel::import(new attendanceImport, $request->file);
            
            return response()->json(['status' => true, 'message' => 'Excel File Successfully Imported']);
        } catch (Exception $ex) {
            if ($ex->getCode() === 422) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }else {
                return response()->json(['status' => false, 'message' => "Internal Server Error"], 500);
            }
        }
           
    }

    public function getAttendanceList(getAttendanceListRequest $request)
    {
        try {
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
                                ->where('check_in', '>=', $from)
                                ->where('check_out', '<=', $to)
                                ->get();

            return response()->json(['status' => true, 'data' => $attendance]);

        } catch (Exception $ex) {
            if ($ex->getCode() === 422) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }else {
                return response()->json(['status' => false, 'message' => "internal server error"], 500);
            }
        }
    }

    public function getEmployeeAttendance(getEmployeeAtendanceRequest $request, $employee_id)
    {
        try {
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

            return response()->json(['status' => true, 'data' =>[ 'attendance' => $emplyee_attendance, 'total_hours' => $total_working_hours]]);
        } catch (Exception $ex) {
            if ($ex->getCode() === 422) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }else {
                return response()->json(['status' => false, 'message' => 'internal server error'], 500);
            }
        }
    }

}
