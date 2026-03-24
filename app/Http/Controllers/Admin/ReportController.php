<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $activities = collect();

        // New user registrations
        User::latest()->get()->each(function($u) use (&$activities) {
            $activities->push([
                'event'        => 'New user account created — ' . $u->firstname . ' ' . $u->lastname,
                'dot'          => 'dot-green',
                'type'         => 'Registration',
                'performed_by' => $u->firstname . ' ' . $u->lastname,
                'time'         => $u->created_at,
            ]);
        });

        // Approved accounts
        User::whereNotNull('approved_at')->orderByDesc('approved_at')->get()->each(function($u) use (&$activities) {
            $activities->push([
                'event'        => 'Account approved — ' . $u->firstname . ' ' . $u->lastname,
                'dot'          => 'dot-blue',
                'type'         => 'Approval',
                'performed_by' => 'Super Admin',
                'time'         => $u->approved_at,
            ]);
        });

        // Pending account requests
        User::where('is_approved', false)->latest()->get()->each(function($u) use (&$activities) {
            $activities->push([
                'event'        => 'Pending account request — ' . $u->firstname . ' ' . $u->lastname,
                'dot'          => 'dot-yellow',
                'type'         => 'Pending',
                'performed_by' => $u->firstname . ' ' . $u->lastname,
                'time'         => $u->created_at,
            ]);
        });

        // Sort all by latest
        $activities = $activities->sortByDesc('time')->values();

        return view('admin.reports.index', compact('activities'));
    }
}