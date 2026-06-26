@extends('layouts.admin')

@section('title','Department Dashboard')

@section('content')

<style>

.dashboard-container{
    padding:30px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.page-header h1{
    font-size:34px;
    font-weight:700;
    color:#111827;
}

.page-header p{
    margin-top:6px;
    color:#6B7280;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:#fff;
    border-radius:16px;
    padding:24px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    border:1px solid #E5E7EB;
}

.stat-card h3{
    color:#6B7280;
    font-size:15px;
    margin-bottom:12px;
}

.stat-card h1{
    font-size:36px;
    color:#111827;
    margin:0;
}

.card{
    background:#fff;
    border-radius:16px;
    padding:24px;
    margin-bottom:25px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    border:1px solid #E5E7EB;
}

.card h2{
    margin-bottom:20px;
    font-size:22px;
    color:#111827;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    text-align:left;
    padding:14px;
    background:#F9FAFB;
    color:#6B7280;
    font-size:14px;
}

.table td{
    padding:16px 14px;
    border-top:1px solid #E5E7EB;
}

.badge{
    padding:6px 12px;
    border-radius:999px;
    color:#fff;
    font-size:12px;
}

.status-pending{
    background:#EF4444;
}

.status-submitted{
    background:#F59E0B;
}

.status-in_progress{
    background:#2563EB;
}

.status-resolved{
    background:#10B981;
}

.btn-view{
    background:#2563EB;
    color:#fff;
    text-decoration:none;
    padding:8px 16px;
    border-radius:8px;
    font-size:14px;
}

.notification-item{
    padding:14px;
    border-bottom:1px solid #E5E7EB;
}

.notification-item small{
    display:block;
    color:#6B7280;
    margin-top:4px;
}

</style>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<div class="dashboard-container">

    <div class="page-header">

        <div>

            <h1>
                {{ auth()->user()->department->name }}
            </h1>

            <p>
                Department Head Dashboard
            </p>

        </div>

    </div>

    <div class="stats-grid">

        <div class="stat-card">
            <h3>Total Reports</h3>
            <h1>{{ $totalReports }}</h1>
        </div>

        <div class="stat-card">
            <h3>Pending</h3>
            <h1>{{ $pendingReports }}</h1>
        </div>

        <div class="stat-card">
            <h3>In Progress</h3>
            <h1>{{ $inProgressReports }}</h1>
        </div>

        <div class="stat-card">
            <h3>Resolved</h3>
            <h1>{{ $resolvedReports }}</h1>
        </div>

    </div>

    <div class="card">

        <h2>Department Reports Map</h2>

        <div id="reportMap"
             style="height:450px;border-radius:12px;">
        </div>

    </div>

    <div class="card">

        <h2>Department Reports</h2>

        <table class="table">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th></th>

                </tr>

            </thead>

            <tbody>

                @foreach($reports as $report)

                    <tr>

                        <td>#CP-{{ $report->id }}</td>

                        <td>{{ $report->title }}</td>

                        <td>{{ $report->priority }}</td>

                        <td>{{ ucfirst($report->status) }}</td>

                        <td>

                            <a href="{{ route('admin.reports.show',$report->id) }}">

                                View

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <br>

        {{ $reports->links() }}

    </div>

    <div class="card">

        <h2>Department Officers</h2>

        <table class="table">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($officers as $officer)

                    <tr>

                        <td>{{ $officer->name }}</td>

                        <td>{{ ucwords(str_replace('_',' ',$officer->role)) }}</td>

                        <td>{{ ucfirst($officer->status) }}</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="card">

        <h2>Notifications</h2>

        @forelse($notifications as $notification)

            <p>

                {{ $notification->message }}

            </p>

        @empty

            <p>No notifications.</p>

        @endforelse

    </div>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@stack('scripts')

<script>

const map = L.map('reportMap').setView([23.8315,91.2868],12);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'© OpenStreetMap'
}).addTo(map);

const reports=@json($mapReports);

reports.forEach(report=>{

    let color='#2563EB';

    if(report.status==='resolved')
        color='#16A34A';

    if(report.status==='pending')
        color='#DC2626';

    if(report.status==='in_progress')
        color='#F59E0B';

    const icon=L.divIcon({

        html:`
        <div style="
            width:18px;
            height:18px;
            background:${color};
            border-radius:50%;
            border:3px solid white;">
        </div>`,

        className:''

    });

    L.marker(
        [report.latitude,report.longitude],
        {icon}
    )
    .addTo(map)
    .bindPopup(`
        <b>${report.title}</b><br>
        ${report.status}
    `);

});

setTimeout(()=>{
    map.invalidateSize();
},300);

</script>

@endsection