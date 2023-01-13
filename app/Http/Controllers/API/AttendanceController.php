<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\attendanceImport;
use Illuminate\Http\Request;
use Excel;

class AttendanceController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $excel_import = Excel::import(new attendanceImport, $request->file);
        return response()->json(true);   
    }

    public function getAttendance(Request $request)
    {
        return response()->json(true);
    }

}
