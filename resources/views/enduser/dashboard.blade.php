{{-- resources/views/enduser/dashboard.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Dashboard'])

@section('content')

    @php
        $activeRequests = $requests ?? collect();

        $withProcurementCount = $activeRequests->whereIn('status', [
            'submitted_to_procurement',
            'processing',
            'bac_processing',
            'approved',
            'final_approved',
            'signed_pr',
            'validated_payment',
        ])->count();

        $withFaiiCount = $activeRequests->whereIn('status', [
            'faii',
            'with_faii',
            'faii_processing',
        ])->count();

        $withFindingsCount = $activeRequests->whereIn('status', [
            'returned',
            'rejected',
            'with_findings',
        ])->count();

        $resolveStage = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));
            return match ($status) {
                'draft' => 'Draft Proposal Created',
                'pending', 'submitted_to_rd' => 'Waiting for RD Approval',
                'submitted_to_procurement', 'processing', 'bac_processing' => 'Receive Proposal Notification',
                'approved', 'final_approved' => 'Sign Activity Proposal',
                'signed_pr' => 'Submit Final Docs for Payment',
                'validated_payment' => 'Prepare OBR for DC Signature',
                'returned', 'rejected', 'with_findings' => 'Review / Revise Draft Proposal',
                default => 'Waiting for RD Approval',
            };
        };

        $resolveLane = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));
            return match ($status) {
                'submitted_to_procurement', 'processing', 'bac_processing' => 'APPROVER',
                'faii', 'with_faii', 'faii_processing' => 'FAII',
                'returned', 'rejected', 'with_findings' => 'APPROVER',
                default => 'ENDUSER',
            };
        };

        $resolveLaneClass = function ($lane) {
            return match ($lane) {
                'APPROVER' => 'background:#efe3ff;color:#7b3fb2;',
                'FAII' => 'background:#ffe9a8;color:#8a5b00;',
                default => 'background:#ccefc5;color:#2a7a2f;',
            };
        };

        $resolveMiniBadge = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));
            return match ($status) {
                'submitted_to_procurement', 'processing', 'bac_processing' => ['RECEIVE', '#e8e0ff', '#7a54c7'],
                'approved', 'final_approved' => ['SIGN', '#dbe9ff', '#2d5ca8'],
                'returned', 'rejected', 'with_findings' => ['REVISE', '#ffd3d3', '#b53b3b'],
                default => ['PREPARE', '#fff0b8', '#8a5b00'],
            };
        };
    @endphp

    <div style="margin-bottom:10px;font-size:12px;color:#8c97a5;">
        Management Dashboard
    </div>

    <div class="stats" style="margin-bottom:12px;">
        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $activeRequests->count() }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">Active Requests</div>
        </div>
        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withProcurementCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With Procurement</div>
        </div>
        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withFaiiCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With FA II</div>
        </div>
        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withFindingsCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With Findings</div>
        </div>
    </div>

    <div class="panel" style="border-radius:14px;">
        <div class="panel-header" style="background:#ffffff;color:#111827;border-bottom:1px solid #dbe3ef;padding:12px 14px;">
            <span style="font-weight:700;">Active Procurement Pipeline</span>

            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" placeholder="Search ID or title..."
                        style="height:32px;width:170px;border:1px solid #d5dbe5;border-radius:8px;padding:0 12px 0 30px;font-size:12px;outline:none;background:#fafbfd;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#9aa3ad" stroke-width="2"
                        style="position:absolute;left:10px;top:50%;transform:translateY(-50%);">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <button type="button" onclick="openProposalModal()"
                    style="display:inline-flex;align-items:center;justify-content:center;height:32px;padding:0 16px;background:#2459d3;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">
                    + New Activity Proposal
                </button>
            </div>
        </div>

        <div class="panel-body" style="padding:0;">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:150px;">Document ID</th>
                            <th>Activity / Description</th>
                            <th style="width:290px;">Current Stage</th>
                            <th style="width:120px;">Lane</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeRequests as $request)
                            @php
                                $stage = $resolveStage($request);
                                $lane  = $resolveLane($request);
                                [$miniLabel, $miniBg, $miniColor] = $resolveMiniBadge($request);
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:inline-block;background:#dbe9ff;color:#2459d3;font-size:10px;font-weight:700;border-radius:6px;padding:3px 8px;margin-bottom:4px;">
                                        {{ $request->pr_number ?? $request->doc_number ?? ('DSWD-' . str_pad($request->id, 4, '0', STR_PAD_LEFT)) }}
                                    </div>
                                    <div class="muted" style="font-size:10px;">
                                        {{ !empty($request->request_date) ? \Carbon\Carbon::parse($request->request_date)->format('n/j/Y') : (!empty($request->created_at) ? \Carbon\Carbon::parse($request->created_at)->format('n/j/Y') : '-') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#111827;font-size:12px;">
                                        {{ $request->activity_title ?? $request->purpose ?? '-' }}
                                    </div>
                                    <div class="muted" style="font-size:11px;">
                                        {{ $request->purpose ?? 'Activity proposal' }}
                                        @if($request->fund_source ?? null)· {{ $request->fund_source }}@endif
                                        @if($request->office_department ?? null)· {{ $request->office_department }}@endif
                                        · ₱{{ number_format((float) ($request->estimated_amount ?? $request->total_amount ?? 0), 2) }}
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:flex-start;gap:8px;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#11a0bf;margin-top:5px;flex-shrink:0;"></span>
                                        <div>
                                            <div style="font-size:11px;font-weight:700;color:#1f2937;">{{ $stage }}</div>
                                            <div style="margin-top:4px;">
                                                <span style="display:inline-block;background:{{ $miniBg }};color:{{ $miniColor }};font-size:9px;font-weight:700;border-radius:4px;padding:2px 7px;">
                                                    {{ $miniLabel }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="display:inline-block;border-radius:999px;padding:3px 10px;font-size:10px;font-weight:700;{{ $resolveLaneClass($lane) }}">
                                        {{ $lane }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                        <a href="{{ route('enduser.requests.show', $request->id) }}"
                                            style="display:inline-flex;align-items:center;justify-content:center;min-width:38px;height:22px;background:#2459d3;color:#fff;border-radius:6px;font-size:9px;font-weight:700;text-decoration:none;">
                                            ACT
                                        </a>
                                        @if($request->status === 'approved')
                                            <a href="{{ route('enduser.requests.draft.pr', $request->id) }}"
                                                style="display:inline-flex;align-items:center;justify-content:center;min-width:52px;height:22px;background:#1f3f7d;color:#fff;border-radius:6px;font-size:9px;font-weight:700;text-decoration:none;">
                                                PR
                                            </a>
                                        @endif
                                        <a href="{{ route('enduser.requests.show', $request->id) }}"
                                            style="display:inline-flex;align-items:center;justify-content:center;min-width:48px;height:22px;border:1px solid #d5dbe5;color:#7b8794;border-radius:6px;font-size:9px;font-weight:700;text-decoration:none;background:#fff;">
                                            HISTORY
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-card">No active procurement requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ MODAL: Create Activity Proposal --}}
    <div id="proposal-modal"
         style="display:none;position:fixed;inset:0;z-index:200;background:rgba(15,23,42,.62);padding:18px;overflow:auto;">
        <div style="max-width:900px;margin:3vh auto;background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 28px 60px rgba(2,6,23,.35);">

            {{-- Modal Header --}}
            <div style="background:linear-gradient(135deg,#0f172a,#1d4ed8);color:#fff;padding:20px 24px;display:flex;align-items:flex-start;justify-content:space-between;gap:16px;">
                <div>
                    <div style="font-size:12px;letter-spacing:.18em;text-transform:uppercase;font-weight:800;opacity:.8;">End-User</div>
                    <div style="font-size:22px;font-weight:900;margin-top:6px;">Create Activity Proposal</div>
                    <div style="font-size:13px;opacity:.85;margin-top:6px;">Submit first to the RD/Approver for review.</div>
                </div>
                <button type="button" onclick="closeProposalModal()"
                    style="width:36px;height:36px;border:none;border-radius:999px;background:rgba(255,255,255,.16);color:#fff;font-size:22px;cursor:pointer;line-height:1;">&times;</button>
            </div>

            <form method="POST" action="{{ route('enduser.requests.store.basic') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submit_action" value="pending">

                <div style="padding:24px;background:#f8fafc;">

                    {{-- Row 1: Activity Title, Division/Office, Target Date --}}
                    <div style="display:grid;grid-template-columns:1.2fr 1fr 1fr;gap:14px;">
                        <div class="field">
                            <label>Activity Title *</label>
                            <input type="text" name="activity_title" value="{{ old('activity_title') }}" placeholder="Enter activity title">
                            @error('activity_title')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Division / Office *</label>
                            <input type="text" name="division_office" value="{{ old('division_office') }}" placeholder="Division or office">
                            @error('division_office')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Target Date *</label>
                            <input type="date" name="target_date" value="{{ old('target_date') }}">
                            @error('target_date')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- ✅ Row 2: Activity Date, Venue, Fund Source --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-top:14px;">
                        <div class="field">
                            <label>Activity Date *</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date') }}">
                            @error('activity_date')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Venue *</label>
                            <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. DSWD Regional Office">
                            @error('venue')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Fund Source *</label>
                            <select name="fund_source">
                                <option value="">Select</option>
                                <option value="MOOE" @selected(old('fund_source') === 'MOOE')>MOOE</option>
                                <option value="CO" @selected(old('fund_source') === 'CO')>CO</option>
                                <option value="PS" @selected(old('fund_source') === 'PS')>PS</option>
                            </select>
                            @error('fund_source')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- ✅ Row 3: Estimated Amount + Purpose --}}
                    <div style="display:grid;grid-template-columns:1fr 2fr;gap:14px;margin-top:14px;">
                        <div class="field">
                            <label>Estimated Amount *</label>
                            <input type="number" step="0.01" min="0" name="estimated_amount" value="{{ old('estimated_amount') }}" placeholder="0.00">
                            @error('estimated_amount')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Purpose / Objective *</label>
                            <textarea name="purpose_objective" placeholder="Describe the purpose of the activity">{{ old('purpose_objective') }}</textarea>
                            @error('purpose_objective')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- Upload --}}
                    <div class="field" style="margin-top:14px;">
                        <label>Upload Supporting Documents</label>
                        <input type="file" name="supporting_documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <span style="font-size:11px;color:#64748b;">Accepted: PDF, DOC, DOCX, JPG, PNG — Max 5MB each</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="padding:14px 24px;background:#fff;border-top:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                    <div style="font-size:12px;color:#64748b;">Once submitted, the proposal will go to the Approver for review.</div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <button type="button" onclick="closeProposalModal()"
                            style="height:38px;padding:0 16px;border:1px solid #cbd5e1;background:#fff;border-radius:10px;font-weight:700;color:#334155;cursor:pointer;">
                            Cancel
                        </button>
                        <button type="submit"
                            style="height:38px;padding:0 18px;border:none;background:#1d4ed8;color:#fff;border-radius:10px;font-weight:800;cursor:pointer;">
                            Submit Proposal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openProposalModal() {
            const modal = document.getElementById('proposal-modal');
            if (modal) modal.style.display = 'block';
        }

        function closeProposalModal() {
            const modal = document.getElementById('proposal-modal');
            if (modal) modal.style.display = 'none';
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeProposalModal();
        });

        document.addEventListener('click', function (event) {
            const modal = document.getElementById('proposal-modal');
            if (!modal || modal.style.display === 'none') return;
            if (event.target === modal) closeProposalModal();
        });

        @if($errors->any())
            openProposalModal();
        @endif
    </script>

@endsection