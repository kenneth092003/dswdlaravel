<?php

namespace App\Http\Controllers;

use App\Models\SystemIssue;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'required|string|max:150',
            'email'           => 'required|email|max:150',
            'role'            => 'nullable|string|max:100',
            'issue_type'      => 'required|string|max:100',
            'priority'        => 'nullable|string|max:50',
            'subject'         => 'required|string|max:150',
            'description'     => 'required|string|max:2000',
            'affected_module' => 'nullable|string|max:150',
        ]);

        SystemIssue::create([
            'reported_by'     => auth()->id(),
            'full_name'       => $validated['full_name'],
            'email'           => $validated['email'],
            'role'            => $validated['role'] ?? null,
            'source'          => 'support_page',
            'reporter_name'   => $validated['full_name'],
            'reporter_email'  => $validated['email'],
            'reporter_role'   => $validated['role'] ?? null,
            'issue_type'      => $validated['issue_type'],
            'priority'        => $validated['priority'] ?? 'Medium',
            'subject'         => $validated['subject'],
            'description'     => $validated['description'],
            'affected_module' => $validated['affected_module'] ?? null,
            'status'          => 'Open',
        ]);

        return back()->with('status', 'Your support report has been submitted. The Super Admin can now review it.');
    }
}
