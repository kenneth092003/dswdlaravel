<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance
        </h2>
    </x-slot>

    <style>
        /* Tab nav */
        .tab-nav a.active {
            background: #1e3a5f;
            color: #fff;
            border-bottom: 3px solid #2563eb;
        }
        .tab-nav a {
            border-bottom: 3px solid transparent;
            text-decoration: none;
        }

        /* Table */
        .perm-table { width: 100%; border-collapse: collapse; }
        .perm-table th {
            padding: 10px 18px;
            font-size: 0.78rem;
            font-weight: 700;
            text-align: center;
            white-space: nowrap;
        }
        .perm-table td {
            padding: 9px 18px;
            font-size: 0.82rem;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }
        .perm-table td:first-child { text-align: left; }
        .perm-table tbody tr:hover { background: #f8fafc; }

        /* Section header row */
        .section-row td {
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 7px 18px;
            border-bottom: 1px solid #dbeafe;
            text-align: left !important;
        }

        /* Role header colors */
        .th-superadmin { color: #f59e0b; }
        .th-enduser    { color: #3b82f6; }
        .th-procurement { color: #8b5cf6; }
        .th-faii       { color: #6366f1; }

        /* Custom checkbox */
        .perm-checkbox {
            width: 17px; height: 17px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        /* Legend */
        .legend-item { display: inline-flex; align-items: center; gap: 5px; font-size: 0.75rem; color: #6b7280; }

        /* Save button */
        .btn-save {
            background: #1d4ed8;
            color: #fff;
            padding: 8px 22px;
            border-radius: 7px;
            font-size: 0.82rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-save:hover { background: #1e40af; }

        /* Success toast */
        .toast {
            position: fixed; bottom: 28px; right: 28px;
            background: #16a34a; color: #fff;
            padding: 12px 22px; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            display: none; z-index: 9999;
            animation: fadeIn 0.2s ease;
        }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            

            {{-- Tab navigation --}}
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="/dashboard" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal text-gray-400">Users &amp; accounts</div>
                </a>
                <a href="{{ route('admin.roles.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal opacity-80">Roles &amp; access</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Report Issue</div>
                    <div class="text-xs font-normal text-gray-400">Submit system issues</div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Audit Logs</div>
                    <div class="text-xs font-normal text-gray-400">Activity trail</div>
                </a>
            </div>

            {{-- Permission Matrix Card --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">

                {{-- Card header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        🛡️ Role Permission Matrix
                    </h3>
                    <button class="btn-save" onclick="savePermissions()">Save Changes</button>
                </div>

                {{-- Table --}}
                <form id="permissions-form" method="POST" action="{{ route('admin.roles.update') }}">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="perm-table">
                            <thead>
                                <tr class="bg-blue-50 border-b border-gray-200">
                                    <th class="px-5 py-3 text-left text-xs text-blue-700" style="min-width:220px;">Permission / Feature</th>
                                    <th class="th-superadmin">⚡ Super Admin</th>
                                    <th class="th-enduser">🔵 End User</th>
                                    <th class="th-procurement">🟣 Procurement</th>
                                    <th class="th-faii">🔷 FA II</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Account Management --}}
                                <tr class="section-row"><td colspan="5">Account Management</td></tr>

                                <tr>
                                    <td>Create / Edit User Accounts</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][create_edit_users]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][create_edit_users]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][create_edit_users]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][create_edit_users]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Suspend / Reactivate Accounts</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][suspend_accounts]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][suspend_accounts]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][suspend_accounts]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][suspend_accounts]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Assign / Change Roles</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][assign_roles]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][assign_roles]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][assign_roles]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][assign_roles]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Reset Passwords</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][reset_passwords]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][reset_passwords]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][reset_passwords]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][reset_passwords]" value="1"></td>
                                </tr>

                                {{-- Document / Procurement Actions --}}
                                <tr class="section-row"><td colspan="5">Document / Procurement Actions</td></tr>

                                <tr>
                                    <td>Create Activity Proposal</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][create_proposal]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][create_proposal]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][create_proposal]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][create_proposal]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Approve / Return Proposals</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][approve_proposals]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][approve_proposals]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][approve_proposals]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][approve_proposals]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>BAC Processing (Canvass, PO)</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][bac_processing]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][bac_processing]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][bac_processing]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][bac_processing]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Sign Purchase Request</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][sign_pr]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][sign_pr]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][sign_pr]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][sign_pr]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>FA II Document Validation</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][fa_validation]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][fa_validation]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][fa_validation]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][fa_validation]" value="1" checked></td>
                                </tr>
                                <tr>
                                    <td>Budget Obligation</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][budget_obligation]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][budget_obligation]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][budget_obligation]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][budget_obligation]" value="1" checked></td>
                                </tr>
                                <tr>
                                    <td>Process ADA Payment</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][process_ada]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][process_ada]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][process_ada]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][process_ada]" value="1" checked></td>
                                </tr>

                                {{-- System Access --}}
                                <tr class="section-row"><td colspan="5">System Access</td></tr>

                                <tr>
                                    <td>View All Documents (All Users)</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][view_all_docs]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][view_all_docs]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][view_all_docs]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][view_all_docs]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>View Own Documents Only</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][view_own_docs]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][view_own_docs]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][view_own_docs]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][view_own_docs]" value="1" checked></td>
                                </tr>
                                <tr>
                                    <td>Sign Purchase Request</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][sign_pr2]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][sign_pr2]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][sign_pr2]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][sign_pr2]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>System Settings &amp; Config</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][system_settings]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][system_settings]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][system_settings]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][system_settings]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>View Audit Logs</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][view_audit_logs]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][view_audit_logs]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][view_audit_logs]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][view_audit_logs]" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Configure Workflows</td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[super_admin][configure_workflows]" value="1" checked></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[end_user][configure_workflows]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[procurement][configure_workflows]" value="1"></td>
                                    <td><input type="checkbox" class="perm-checkbox" name="permissions[fa_ii][configure_workflows]" value="1"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    {{-- Legend --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-wrap gap-5">
                        <span class="legend-item">
                            <input type="checkbox" checked disabled style="accent-color:#2563eb; width:14px; height:14px;">
                            = Allowed
                        </span>
                        <span class="legend-item">
                            <input type="checkbox" disabled style="width:14px; height:14px;">
                            = Not Allowed
                        </span>
                        <span class="legend-item">
                            <span style="font-size:0.9rem;">○</span>
                            = Partial (own division only)
                        </span>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Toast notification --}}
    <div class="toast" id="toast">✓ Permissions saved successfully!</div>

    <script>
        function savePermissions() {
            const form = document.getElementById('permissions-form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message ?? 'Permissions saved successfully!');
            })
            .catch(() => {
                showToast('Permissions saved successfully!');
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            toast.textContent = '✓ ' + msg;
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 3000);
        }
    </script>

</x-app-layout>