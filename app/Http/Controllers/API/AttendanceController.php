<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadExcelRequest;
use App\Imports\attendanceImport;
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

    public function getAttendance(Request $request)
    {
        return response()->json(true);
    }

}
