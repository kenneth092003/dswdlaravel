{{-- resources/views/enduser/requests/create.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - New Activity Proposal'])

@section('content')
    <div class="wizard-overlay">
        <div class="wizard" style="max-width:1100px;">
            <div class="wizard-header">
                <div>
                    <div class="wizard-title">New Activity Proposal</div>
                    <div class="wizard-sub">Submit your proposal to the RD/Approver for review.</div>
                </div>
                <a href="{{ route('enduser.dashboard') }}" class="close-x" style="text-decoration:none;color:#fff;">&times;</a>
            </div>

            <form method="POST" action="{{ route('enduser.requests.store.basic') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submit_action" value="pending">

                <div class="wizard-body">
                    <div class="hint-box">
                        Fill in the details of your activity proposal. Once submitted, it will be queued for RD approval.
                    </div>

                    <div class="section-title">Activity Proposal</div>

                    <div class="grid-3">
                        <div class="field">
                            <label>Activity Title *</label>
                            <input type="text" name="activity_title" value="{{ old('activity_title') }}">
                            @error('activity_title')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Division / Office *</label>
                            <input type="text" name="division_office" value="{{ old('division_office') }}">
                            @error('division_office')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Target Date *</label>
                            <input type="date" name="target_date" value="{{ old('target_date') }}">
                            @error('target_date')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="grid-3" style="margin-top:10px;">
                        <div class="field">
                            <label>Activity Date *</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date') }}">
                            @error('activity_date')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Venue *</label>
                            <input type="text" name="venue" placeholder="e.g. DSWD Regional Office" value="{{ old('venue') }}">
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

                    <div class="grid-3" style="margin-top:10px;">
                        <div class="field">
                            <label>Estimated Amount *</label>
                            <input type="number" step="0.01" min="0" name="estimated_amount" value="{{ old('estimated_amount') }}">
                            @error('estimated_amount')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field" style="grid-column:span 2;">
                            <label>Purpose / Objective *</label>
                            <textarea name="purpose_objective">{{ old('purpose_objective') }}</textarea>
                            @error('purpose_objective')<span style="color:#e53935;font-size:11px;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="field" style="margin-top:10px;">
                        <label>Upload Supporting Documents</label>
                        <input type="file" name="supporting_documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <span style="font-size:11px;color:#6c7785;">Accepted: PDF, DOC, DOCX, JPG, PNG — Max 5MB each</span>
                    </div>
                </div>

                <div class="wizard-footer">
                    <div class="footer-note">After submit, the proposal will be visible to the Approver.</div>
                    <div class="actions">
                        <a href="{{ route('enduser.dashboard') }}" class="btn-outline">Cancel</a>
                        <button type="submit" class="btn-green">Submit Proposal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection