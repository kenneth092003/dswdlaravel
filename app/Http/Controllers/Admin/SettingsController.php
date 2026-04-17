<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemIssue;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $recentIssues = collect();

        if (\Schema::hasTable('system_issues')) {
            $recentIssues = SystemIssue::with('reportedBy')
                ->latest()
                ->limit(5)
                ->get();
        }

        return view('admin.settings.index', compact('recentIssues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'nullable|string|max:150',
            'email'           => 'nullable|email|max:150',
            'role'            => 'nullable|string|max:100',
            'issue_type'      => 'required|string|max:100',
            'priority'        => 'required|string|max:50',
            'subject'         => 'required|string|max:150',
            'description'     => 'required|string|max:2000',
            'affected_module' => 'nullable|string|max:150',
        ]);

        $user = auth()->user();

        if (\Schema::hasTable('system_issues')) {
            SystemIssue::create([
                'reported_by'     => auth()->id(),
                'reporter_name'   => $validated['full_name'] ?? $user?->full_name,
                'reporter_email'  => $validated['email'] ?? $user?->email,
                'reporter_role'   => $validated['role'] ?? null,
                'issue_type'      => $validated['issue_type'],
                'priority'        => $validated['priority'],
                'subject'         => $validated['subject'],
                'description'     => $validated['description'],
                'affected_module' => $validated['affected_module'] ?? null,
                'status'          => 'Open',
            ]);
        }

        return back()->with('status', 'Issue report submitted successfully. The administrator has been notified.');
    }

    public function destroy(SystemIssue $issue)
    {
        $issue->delete();

        return back()->with('status', 'Support complaint deleted successfully.');
    }
}
