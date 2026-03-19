<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Review Purchase Request - PROMIS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #0f1c2e;
            --navy2: #162436;
            --accent: #3b82f6;
            --green: #10b981;
            --red: #ef4444;
            --text: #e2e8f0;
            --muted: #64748b;
            --border: rgba(255,255,255,0.07);
            --card: rgba(255,255,255,0.04);
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            color: var(--text);
            padding: 28px;
        }
        .page {
            max-width: 1100px;
            margin: 0 auto;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 18px;
        }
        .title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .sub {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 16px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        .field label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .field .value {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            min-height: 44px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .table-wrap {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }
        th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        tr:last-child td {
            border-bottom: none;
        }
        textarea {
            width: 100%;
            min-height: 90px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.03);
            color: var(--text);
            padding: 12px;
            resize: vertical;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 16px;
        }
        .btn {
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-blue { background: var(--accent); text-decoration: none; display: inline-block; }
        .btn-green { background: var(--green); }
        .btn-red { background: var(--red); }
        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .alert-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.35);
            color: #a7f3d0;
        }
        .alert-error {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.35);
            color: #fecaca;
        }
        .error-text {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="page">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="title">Purchase Request Review</div>
            <div class="sub">Review the submitted request before approving or rejecting.</div>

            <div class="grid">
                <div class="field">
                    <label>Doc No.</label>
                    <div class="value">{{ $purchaseRequest->pr_number ?? '-' }}</div>
                </div>
                <div class="field">
                    <label>Status</label>
                    <div class="value">{{ ucwords(str_replace('_', ' ', $purchaseRequest->status ?? 'draft')) }}</div>
                </div>
                <div class="field">
                    <label>Date Filed</label>
                    <div class="value">
                        {{ $purchaseRequest->request_date ? \Carbon\Carbon::parse($purchaseRequest->request_date)->format('M d, Y') : '-' }}
                    </div>
                </div>
                <div class="field">
                    <label>End User</label>
                    <div class="value">
                        {{ $purchaseRequest->user ? $purchaseRequest->user->firstname . ' ' . $purchaseRequest->user->lastname : 'N/A' }}
                    </div>
                </div>
                <div class="field">
                    <label>Division / Office</label>
                    <div class="value">{{ $purchaseRequest->office_department ?? '-' }}</div>
                </div>
                <div class="field">
                    <label>Total Amount</label>
                    <div class="value">₱{{ number_format((float) ($purchaseRequest->total_amount ?? 0), 2) }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Purpose</div>
            <div class="field">
                <div class="value">{{ $purchaseRequest->purpose ?? '-' }}</div>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Requested Items</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Unit Cost</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseRequest->items as $item)
                            <tr>
                                <td>{{ $item->item_description ?? '-' }}</td>
                                <td>{{ $item->unit ?? '-' }}</td>
                                <td>{{ $item->qty ?? 0 }}</td>
                                <td>₱{{ number_format((float) ($item->estimated_unit_cost ?? 0), 2) }}</td>
                                <td>₱{{ number_format((float) ($item->total_amount ?? (($item->qty ?? 0) * ($item->estimated_unit_cost ?? 0))), 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Attachments</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>File Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseRequest->attachments as $attachment)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $attachment->file_type)) }}</td>
                                <td>{{ $attachment->file_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No attachments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <form method="POST" action="{{ route('procurement.requests.reject', $purchaseRequest->id) }}" style="margin-top:16px;">
                @csrf

                <div class="section-title">Remarks for rejection</div>
                <textarea name="remarks" placeholder="Add reason if rejecting this request..." required>{{ old('remarks') }}</textarea>

                @error('remarks')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <div class="actions">
                    <a href="{{ route('procurement.dashboard') }}" class="btn btn-blue">Back</a>
                    <button type="submit" class="btn btn-red">Reject</button>
                </div>
            </form>

            <form method="POST" action="{{ route('procurement.requests.approve', $purchaseRequest->id) }}" style="margin-top:10px;">
                @csrf

                <div class="actions">
                    <button type="submit" class="btn btn-green">Approve</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
