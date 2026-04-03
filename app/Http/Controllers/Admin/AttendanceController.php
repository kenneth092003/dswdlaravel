<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('attendances')
                      ->groupBy('user_id');
            })
            ->latest('login_at')
            ->paginate(20);

        return view('admin.attendance.index', compact('attendances'));
    }
}