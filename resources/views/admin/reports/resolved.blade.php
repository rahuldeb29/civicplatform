@extends('layouts.admin')

@section('title', 'Pending Reports')

@section('content')

<!-- Custom CSS for this page -->
<style>
    .page-container { padding: 2rem; background-color: #f4f6f9; min-height: 100vh; }
    .page-header { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #2d3748; margin: 0; }
    .page-header p { color: #718096; margin: 0.25rem 0 0 0; }

    .stats-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; }
    .stat-item { background: white; padding: 1rem 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); flex: 1; }
    .stat-value { font-size: 1.25rem; font-weight: 700; color: #2d3748; }
    .stat-label { font-size: 0.875rem; color: #718096; }

    .table-card { background: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; }
    
    .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #fafafa; }
    .search-box { position: relative; }
    .search-box input { padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e2e8f0; border-radius: 9999px; font-size: 0.875rem; outline: none; transition: all 0.2s; }
    .search-box input:focus { border-color: #4299e1; box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2); }
    .search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #a0aec0; width: 1rem; height: 1rem; }

    .table-wrapper { overflow-x: auto; }
    .modern-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .modern-table thead { background-color: #f7fafc; }
    .modern-table th { padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #718096; font-weight: 600; border-bottom: 2px solid #edf2f7; }
    .modern-table td { padding: 1rem 1.5rem; font-size: 0.9375rem; color: #4a5568; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .modern-table tbody tr:hover { background-color: #f9fafb; }
    .modern-table tbody tr:last-child td { border-bottom: none; }

    /* Status & Priority Badges */
    .badge { padding: 0.35rem 0.75rem; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-block; text-transform: capitalize; letter-spacing: 0.025em; }
    
    /* Priority Colors */
    .priority-high { background-color: #fed7d7; color: #c53030; }
    .priority-medium { background-color: #feebc8; color: #c05621; }
    .priority-low { background-color: #c6f6d5; color: #276749; }

    /* Status Colors */
    .status-pending { background-color: #e2e8f0; color: #4a5568; }
    .status-in_progress { background-color: #bee3f8; color: #2b6cb0; }
    .status-resolved { background-color: #c6f6d5; color: #276749; }
    .status-rejected { background-color: #fed7d7; color: #c53030; }

    /* Action Button */
    .btn-action { padding: 0.5rem 1rem; background-color: #4299e1; color: white; border-radius: 0.375rem; font-size: 0.8125rem; font-weight: 500; text-decoration: none; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 0.25rem; }
    .btn-action:hover { background-color: #3182ce; }
    
    .user-cell { display: flex; align-items: center; gap: 0.75rem; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #4a5568; font-weight: 600; font-size: 0.75rem; }

    .empty-state { text-align: center; padding: 3rem 1rem; color: #a0aec0; }
</style>

<div class="page-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1>Resolved Reports</h1>
            <p>Manage and monitor all citizen complaints efficiently.</p>
        </div>
        <!-- Optional: Add a button here if needed, e.g., Export -->
    </div>

    <!-- Main Card -->
    <div class="table-card">
        
        <!-- Card Header with Search -->
        <div class="card-header">
            <div style="font-weight: 600; color: #2d3748;">Resolved Complaint List</div>
            <div class="search-box">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search reports...">
            </div>
        </div>

        <!-- Table Content -->
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Citizen</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <!-- ID -->
                            <td style="font-family: monospace; color: #718096; font-weight: 600;">
                                #CP-{{ $report->id }}
                            </td>

                            <!-- Citizen -->
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($report->user?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span>{{ $report->user?->name ?? 'Unknown' }}</span>
                                </div>
                            </td>

                            <!-- Title -->
                            <td>
                                <div style="font-weight: 500; color: #2d3748;">{{ Str::limit($report->title, 30) }}</div>
                            </td>

                            <!-- Category -->
                            <td>{{ $report->category }}</td>

                            <!-- Priority -->
                            <td>
                                <span class="badge priority-{{ strtolower($report->priority) }}">
                                    {{ $report->priority }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge status-{{ strtolower(str_replace('_', '-', $report->status)) }}">
                                    {{ Str::title(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td>
                                <div style="white-space: nowrap;">
                                    {{ $report->created_at->format('d M, Y') }}
                                </div>
                            </td>

                            <!-- Action -->
                            <td>
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="btn-action">
                                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg style="width: 48px; height: 48px; margin: 0 auto 1rem auto; color: #cbd5e0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <h3 style="font-size: 1rem; color: #4a5568; margin-bottom: 0.5rem;">No reports found</h3>
                                    <p style="font-size: 0.875rem;">There are no citizen complaints matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($reports->hasPages())
            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background: #fafafa;">
                {{ $reports->links() }}
            </div>
        @endif

    </div>
</div>

@endsection