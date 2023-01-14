<?php

namespace App\Http\Controllers\AppHumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\getAttendanceListRequest;
use App\Http\Requests\getEmployeeAtendanceRequest;
use App\Http\Requests\UploadExcelRequest;
use App\Imports\attendanceImport;
use App\Services\AttendanceService;
use Excel;
use Exception;

class AttendanceController extends Controller
{
    private $AttendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->AttendanceService = $attendanceService;
    }

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

            $data = $this->AttendanceService->get_attendance_list($request);

            return response()->json(['status' => true, 'data' => $data]);

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

            $data = $this->AttendanceService->get_employee_attendance($request, $employee_id);

            return response()->json(['status' => true, 'data' => $data]);
       
        } catch (Exception $ex) {
            if ($ex->getCode() === 422) {
                return response()->json(['status' => false, 'message' => $ex->getMessage()], 422);
            }else {
                return response()->json(['status' => false, 'message' => 'internal server error'], 500);
            }
        }
    }

}
