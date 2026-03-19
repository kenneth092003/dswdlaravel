@extends('layouts.enduser-internal', ['title' => 'End User - New Proposal / Basic Info'])

@section('content')
    <div class="wizard-overlay">
        <div class="wizard">
            <div class="wizard-header">
                <div>
                    <div class="wizard-title">New Activity Proposal</div>
                    <div class="wizard-sub">Complete all steps before submitting for RD approval</div>
                </div>
                <div class="close-x">×</div>
            </div>

            <div class="steps">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <span>Basic Info</span>
                </div>
                <div class="step">
                    <div class="step-circle">2</div>
                    <span>Items & Initial Attachments</span>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <span>Final Attachments</span>
                </div>
            </div>

            <form method="POST" action="{{ route('enduser.requests.store.basic') }}">
                @csrf

                <div class="wizard-body">
                    <div class="hint-box">
                        Fill in the details of your activity proposal. This will be reviewed and approved by the Regional Director before proceeding to procurements.
                    </div>

                    <div class="section-title">Activity Information</div>

                    <div class="grid-3">
                        <div class="field">
                            <label>Activity / Proposal Title *</label>
                            <input type="text" name="activity_title" value="{{ old('activity_title') }}">
                        </div>
                        <div class="field">
                            <label>Division / Office *</label>
                            <input type="text" name="division_office" value="{{ old('division_office') }}">
                        </div>
                        <div class="field">
                            <label>Fund Source *</label>
                            <input type="text" name="fund_source" value="{{ old('fund_source') }}">
                        </div>
                    </div>

                    <div class="grid-3" style="margin-top:10px;">
                        <div class="field">
                            <label>Activity Date *</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date') }}">
                        </div>
                        <div class="field">
                            <label>Expected Venue *</label>
                            <input type="text" name="expected_venue" value="{{ old('expected_venue') }}">
                        </div>
                        <div class="field">
                            <label>Priority Level *</label>
                            <input type="text" name="priority_level" value="{{ old('priority_level') }}">
                        </div>
                    </div>

                    <div class="section-title">Justification</div>

                    <div class="field">
                        <label>Purpose / Justification *</label>
                        <textarea name="purpose_justification">{{ old('purpose_justification') }}</textarea>
                    </div>

                    <div class="field" style="margin-top:10px;">
                        <label>Expected Output / Deliverables</label>
                        <textarea name="expected_output">{{ old('expected_output') }}</textarea>
                    </div>
                </div>

                <div class="wizard-footer">
    <div class="footer-note">Step 1 of 3 — Activity Proposal</div>
    <div class="actions">
        <a href="{{ route('enduser.requests.index') }}" class="btn-outline">Cancel</a>
        <button type="submit" name="submit_action" value="draft" class="btn-red">Draft Proposal</button>
        <button type="submit" name="submit_action" value="pending" class="btn-green">Submit Proposal</button>
    </div>
</div>
            </form>
        </div>
    </div>
@endsection