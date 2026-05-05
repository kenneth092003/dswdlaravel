<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Review Proposal
            </h2>
            <p class="text-sm text-gray-500">
                {{ $purchaseRequest->pr_number ?? 'PR-' . str_pad($purchaseRequest->id, 4, '0', STR_PAD_LEFT) }}
                &mdash; {{ $purchaseRequest->activity_title ?? $purchaseRequest->purpose ?? 'Activity Proposal' }}
            </p>
        </div>
    </x-slot>

    @php
        $status = strtolower((string) ($purchaseRequest->status ?? 'draft'));
        $isReviewable = in_array($status, ['pending', 'submitted_to_rd']);
        $requesterName = $purchaseRequest->user?->full_name
            ?: trim(($purchaseRequest->user?->firstname ?? '') . ' ' . ($purchaseRequest->user?->lastname ?? ''));

        $originalDocs = $purchaseRequest->attachments->where('file_type', 'supporting_document');
        $signedDoc    = $purchaseRequest->attachments->where('file_type', 'signed_document')->first();
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Back + Status --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <a href="{{ route('approver.dashboard') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-700 font-semibold transition">
                    &larr; Back to Dashboard
                </a>
                <span class="inline-flex rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide
                    @if($status === 'approved') bg-green-100 text-green-800
                    @elseif(in_array($status, ['returned','rejected'])) bg-red-100 text-red-800
                    @else bg-amber-100 text-amber-800 @endif">
                    {{ str_replace('_', ' ', $purchaseRequest->status ?? 'pending') }}
                </span>
            </div>

            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 px-5 py-3 text-sm text-green-800 font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-3 text-sm text-red-800 font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Basic Info --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">Basic Information</h4>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">PR Number</div>
                                <div class="text-sm font-bold text-gray-900">
                                    {{ $purchaseRequest->pr_number ?? 'PR-' . str_pad($purchaseRequest->id, 4, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Requester</div>
                                <div class="text-sm font-bold text-gray-900">{{ $requesterName ?: 'Unknown' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Date Filed</div>
                                <div class="text-sm font-bold text-gray-900">
                                    {{ $purchaseRequest->request_date ? \Carbon\Carbon::parse($purchaseRequest->request_date)->format('M d, Y') : '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Activity Title</div>
                                <div class="text-sm font-bold text-gray-900">{{ $purchaseRequest->activity_title ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Division / Office</div>
                                <div class="text-sm font-bold text-gray-900">{{ $purchaseRequest->office_department ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Fund Source</div>
                                <div class="text-sm font-bold text-gray-900">{{ $purchaseRequest->fund_source ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Target Date</div>
                                <div class="text-sm font-bold text-gray-900">
                                    {{ $purchaseRequest->target_date ? \Carbon\Carbon::parse($purchaseRequest->target_date)->format('M d, Y') : '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Estimated Amount</div>
                                <div class="text-sm font-bold text-gray-900">₱{{ number_format($purchaseRequest->estimated_amount ?? 0, 2) }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Total Amount</div>
                                <div class="text-sm font-bold text-gray-900">₱{{ number_format($purchaseRequest->total_amount ?? 0, 2) }}</div>
                            </div>
                            <div class="sm:col-span-3">
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Purpose / Objective</div>
                                <div class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4">
                                    {{ $purchaseRequest->purpose ?? '-' }}
                                </div>
                            </div>
                            @if($purchaseRequest->remarks)
                                <div class="sm:col-span-3">
                                    <div class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Remarks</div>
                                    <div class="text-sm text-gray-700 bg-amber-50 border border-amber-100 rounded-xl p-4">
                                        {{ $purchaseRequest->remarks }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">Requested Items</h4>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Unit</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Unit Cost</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse($purchaseRequest->items as $index => $item)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->item_description ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->unit ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->qty ?? 0 }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">₱{{ number_format($item->estimated_unit_cost ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                ₱{{ number_format(($item->qty ?? 0) * ($item->estimated_unit_cost ?? 0), 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400">No items added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Original Documents from End User --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">
                                Documents from End User
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">Download, sign manually, then upload below.</p>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($originalDocs as $attachment)
                                @php
                                    $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                    $label = match($ext) {
                                        'pdf'           => 'PDF',
                                        'doc', 'docx'   => 'DOC',
                                        'xls', 'xlsx'   => 'XLS',
                                        default         => strtoupper($ext),
                                    };
                                    $color = match($ext) {
                                        'pdf'           => 'text-red-600',
                                        'doc', 'docx'   => 'text-blue-700',
                                        'xls', 'xlsx'   => 'text-green-700',
                                        default         => 'text-gray-500',
                                    };
                                @endphp
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-4">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 text-xs font-black {{ $color }}">
                                            {{ $label }}
                                        </span>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $attachment->file_name }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">
                                                {{ ucwords(str_replace('_', ' ', $attachment->file_type ?? 'document')) }}
                                                @if($attachment->remarks)
                                                    &mdash; {{ $attachment->remarks }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                       target="_blank"
                                       download="{{ $attachment->file_name }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg bg-blue-950 px-4 py-2 text-xs font-bold text-white hover:bg-blue-800 transition">
                                        &#8595; Download
                                    </a>
                                </div>
                            @empty
                                <div class="px-6 py-8 text-center text-sm text-gray-400">
                                    No documents uploaded by End User.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- ✅ Upload Signed Document --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">
                                Upload Signed Document
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Upload the signed version. End User will be notified automatically.
                            </p>
                        </div>

                        {{-- Show existing signed doc if any --}}
                        @if($signedDoc)
                            <div class="px-6 pt-4">
                                <div class="flex items-center justify-between rounded-xl bg-green-50 border border-green-200 px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-green-100 text-xs font-black text-green-700">
                                            ✓
                                        </span>
                                        <div>
                                            <div class="text-sm font-bold text-green-800">{{ $signedDoc->file_name }}</div>
                                            <div class="text-xs text-green-600 mt-0.5">
                                                Uploaded {{ optional($signedDoc->created_at)->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $signedDoc->file_path) }}"
                                       target="_blank"
                                       download="{{ $signedDoc->file_name }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg bg-green-700 px-4 py-2 text-xs font-bold text-white hover:bg-green-600 transition">
                                        &#8595; Download
                                    </a>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 mb-4 text-center">
                                    You can replace the signed document by uploading a new one below.
                                </p>
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('approver.requests.upload.signed', $purchaseRequest->id) }}"
                              enctype="multipart/form-data"
                              class="p-6 space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">
                                    Signed Document <span class="text-red-500">*</span>
                                </label>
                                <input type="file"
                                       name="signed_document"
                                       accept=".pdf,.doc,.docx"
                                       class="block w-full text-sm text-gray-700 border border-gray-300 rounded-xl px-4 py-2.5
                                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                              file:text-xs file:font-bold file:bg-blue-950 file:text-white
                                              hover:file:bg-blue-800 cursor-pointer">
                                <p class="text-xs text-gray-400 mt-1">Accepted: PDF, DOC, DOCX — Max 5MB</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">
                                    Remarks (Optional)
                                </label>
                                <textarea name="remarks"
                                          rows="2"
                                          placeholder="Add a note for the End User..."
                                          class="block w-full text-sm text-gray-700 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center rounded-xl bg-blue-950 px-4 py-3 text-sm font-bold text-white hover:bg-blue-800 transition">
                                &#8593; Upload Signed Document
                            </button>
                        </form>
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="space-y-6">

                    {{-- Approve / Reject --}}
                    @if($isReviewable)
                        <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">Actions</h4>
                            </div>
                            <div class="p-6 space-y-3">
                                <form method="POST" action="{{ route('approver.requests.approve', $purchaseRequest->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-xl bg-green-600 px-4 py-3 text-sm font-bold text-white hover:bg-green-500 transition">
                                        ✓ Approve Proposal
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('approver.requests.reject', $purchaseRequest->id) }}"
                                      onsubmit="return confirmReject(this);">
                                    @csrf
                                    <input type="hidden" name="remarks" value="">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white hover:bg-red-500 transition">
                                        ✕ Reject Proposal
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Request Info --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">Request Info</h4>
                        </div>
                        <div class="p-6 space-y-3 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Submitted</span>
                                <span class="font-semibold">{{ optional($purchaseRequest->created_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Last Updated</span>
                                <span class="font-semibold">{{ optional($purchaseRequest->updated_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Original Docs</span>
                                <span class="font-semibold">{{ $originalDocs->count() }} file(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Signed Doc</span>
                                <span class="font-semibold {{ $signedDoc ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $signedDoc ? 'Uploaded ✓' : 'Not yet uploaded' }}
                                </span>
                            </div>
                            @if($status === 'approved')
                                <div class="mt-3 rounded-xl bg-green-50 border border-green-200 p-4 text-xs text-green-800 font-semibold">
                                    ✓ This proposal has been approved.
                                </div>
                            @elseif(in_array($status, ['returned','rejected']))
                                <div class="mt-3 rounded-xl bg-red-50 border border-red-200 p-4 text-xs text-red-800 font-semibold">
                                    ✕ This proposal was returned/rejected.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Lifecycle --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h4 class="text-sm font-bold uppercase tracking-wider text-blue-700">Lifecycle</h4>
                        </div>
                        <div class="p-6 space-y-4">
                            @forelse($purchaseRequest->histories->sortBy('step_no') as $h)
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-black
                                        {{ $h->is_current ? 'bg-blue-950 text-white' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $h->step_no }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $h->status_label }}</div>
                                        @if($h->remarks)
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $h->remarks }}</div>
                                        @endif
                                        @if($h->acted_at)
                                            <div class="text-xs text-gray-400 mt-0.5">
                                                {{ \Carbon\Carbon::parse($h->acted_at)->format('M d, Y h:i A') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-400 text-center py-4">No lifecycle history yet.</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmReject(form) {
            const remarks = window.prompt('Add a remark for the rejection (optional):', '');
            if (remarks === null) return false;
            const input = form.querySelector('input[name="remarks"]');
            if (input) input.value = remarks;
            return true;
        }
    </script>

</x-app-layout>