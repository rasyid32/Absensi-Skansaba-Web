<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;

class ScheduleController extends Controller
{
    public function index($id, $day)
    {
        $student = Student::where('id', $id)->first();

        if ($student == null) {
            $response = [
                'message'       => 'Murid Tidak Ditemukan',
                'errors'    => null,
                'data'      => null
            ];
            return response()->json($response);
        }

        $schedules = Schedule::where('grade_id', $student->grade->id)
            ->where('day', $day)
            ->orderBy('time_start', 'ASC')
            ->join('grades', 'schedules.grade_id', '=', 'grades.id')
            ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->select('schedules.time_start', 'schedules.time_finish', 'grades.name as gradeName', 'subjects.name as subjectName')
            ->get();

        $response = [
            'message'       => 'Jadwal Ditemukan',
            'errors'    => null,
            'data'      => [
                'schedules' => $schedules
            ]
        ];
        return response()->json($response);
    }
}