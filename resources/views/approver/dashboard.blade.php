<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Approver Dashboard
            </h2>
            <p class="text-sm text-gray-500">
                RD review workspace for proposals and purchase requests.
            </p>
        </div>
    </x-slot>

    @php
        $requests = $recentRequests ?? collect();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-blue-800 text-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 md:p-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em]">
                            Approved by Super Admin
                        </div>
                        <h3 class="mt-4 text-3xl md:text-4xl font-black leading-tight">
                            Welcome to the Approver review page.
                        </h3>
                        <p class="mt-4 max-w-2xl text-sm md:text-base text-white/80">
                            Diri mo makita ang mga proposal nga nakaabot na sa iyong role. From here, you can review items, track pending approvals, and prepare the next action once the workflow is fully connected.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
                            <div class="text-xs uppercase tracking-[0.18em] text-white/65">Pending Proposals</div>
                            <div class="mt-3 text-4xl font-black">{{ $pendingProposalsCount ?? 0 }}</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
                            <div class="text-xs uppercase tracking-[0.18em] text-white/65">For Review</div>
                            <div class="mt-3 text-4xl font-black">{{ $forReviewCount ?? 0 }}</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-5">
                            <div class="text-xs uppercase tracking-[0.18em] text-white/65">Returned</div>
                            <div class="mt-3 text-4xl font-black">{{ $returnedCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                    <div class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Step 1</div>
                    <h4 class="mt-2 text-lg font-bold text-gray-900">Review Activity Proposals</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Check submitted proposals from End Users and confirm if the activity is ready to move forward.
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                    <div class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Step 2</div>
                    <h4 class="mt-2 text-lg font-bold text-gray-900">Approve or Return</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        If the proposal is complete, approve it. If it needs revisions, return it with remarks for the End User.
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 p-6">
                    <div class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Step 3</div>
                    <h4 class="mt-2 text-lg font-bold text-gray-900">Move to the Next Stage</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Once approved, the request can proceed to the next office in the procurement flow.
                    </p>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between gap-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Recent Requests</h4>
                        <p class="text-sm text-gray-500">Latest items waiting on the Approver side.</p>
                    </div>

                    <a href="{{ route('approver.dashboard') }}"
                       class="inline-flex items-center rounded-xl bg-blue-950 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                        Refresh
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">PR / Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Requester</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Purpose</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($requests as $request)
                                @php
                                    $requesterName = $request->user?->full_name ?: trim(($request->user?->firstname ?? '') . ' ' . ($request->user?->lastname ?? ''));
                                    $isReviewable = in_array(strtolower((string) $request->status), ['pending', 'submitted_to_rd']);
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $request->pr_number ?? 'PR-' . str_pad($request->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $request->created_at?->format('M d, Y') ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $requesterName !== '' ? $requesterName : 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $request->purpose ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $status = strtolower((string) ($request->status ?? 'pending'));
                                        @endphp
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                            @if(in_array($status, ['approved'])) bg-green-100 text-green-800
                                            @elseif(in_array($status, ['returned', 'rejected'])) bg-red-100 text-red-800
                                            @else bg-amber-100 text-amber-800 @endif">
                                            {{ str_replace('_', ' ', $request->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isReviewable)
                                            <div class="flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('approver.requests.approve', $request->id) }}">
                                                    @csrf
                                                    <button type="submit" class="inline-flex rounded-lg bg-green-600 px-3 py-2 text-xs font-bold text-white hover:bg-green-500">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('approver.requests.reject', $request->id) }}" onsubmit="return confirmRejectProposal(this);">
                                                    @csrf
                                                    <input type="hidden" name="remarks" value="">
                                                    <button type="submit" class="inline-flex rounded-lg bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-500">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                        Wala pa tayong request na naka-assign sa Approver view.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
    function confirmRejectProposal(form) {
        const remarks = window.prompt('Add a short remark for the rejection (optional):', '');
        if (remarks === null) {
            return false;
        }

        const input = form.querySelector('input[name="remarks"]');
        if (input) {
            input.value = remarks;
        }

        return true;
    }
</script>

</x-app-layout>
