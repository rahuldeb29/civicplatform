@extends('layouts.app')

@section('title', 'Submit Report')

@section('content')

    <style>
        .submit-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .page-header p {
            color: #6B7280;
            margin-top: 6px;
        }

        .report-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 24px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #1D4ED8;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .upload-box {
            border: 2px dashed #D1D5DB;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: #F9FAFB;
        }

        .summary-item {
            margin-bottom: 16px;
        }

        .summary-label {
            color: #6B7280;
            font-size: 13px;
        }

        .summary-value {
            font-weight: 600;
            color: #111827;
            margin-top: 4px;
        }

        .btn-submit {
            background: #1D4ED8;
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: #1E40AF;
        }
    </style>

    <div class="submit-container">

        <div class="page-header">
            <h1>Submit New Report</h1>
            <p>Report civic issues in your area and help improve community infrastructure.</p>
        </div>

        <div class="report-grid">

            <!-- Left Form -->
            <div>

                <div class="card">
                    <h2 class="card-title">Issue Details</h2>

                    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Report Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Issue Category</label>
                            <select name="category" class="form-control">
                                <option>Road Damage</option>
                                <option>Street Light</option>
                                <option>Water Leakage</option>
                                <option>Garbage</option>
                                <option>Drainage</option>
                                <option>Electricity</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-control">
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                                <option>Critical</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>

                            <div style="display:flex; gap:10px;">
                                <input type="text" id="location" name="location" class="form-control"
                                    placeholder="Enter location">

                                <button type="button" id="fetchLocationBtn" class="btn-submit" style="white-space:nowrap;">
                                    Fetch Current Location
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">GPS Accuracy (meters)</label>
                            <input type="text" name="accuracy" id="accuracy" class="form-control" readonly>
                        </div>

                        <div id="locationStatus" style="margin-top:8px;font-size:13px;color:#6B7280;">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Upload Evidence</label>

                            <div class="upload-box">
                                <input type="file" name="image">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            Submit Report
                        </button>




                    </form>
                </div>

            </div>

            <!-- Right Summary -->
            <div>

                <div class="card">
                    <h2 class="card-title">Report Summary</h2>

                    <div class="summary-item">
                        <div class="summary-label">Status</div>
                        <div class="summary-value">Draft</div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-label">Department</div>
                        <div class="summary-value">Auto Assigned</div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-label">Estimated Response</div>
                        <div class="summary-value">24 - 48 Hours</div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-label">Citizen</div>
                        <div class="summary-value">
                            {{ Auth::user()->name }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        document.getElementById('fetchLocationBtn')
            .addEventListener('click', function () {

                const status = document.getElementById('locationStatus');

                if (!navigator.geolocation) {
                    status.innerHTML = "Geolocation is not supported.";
                    return;
                }

                status.innerHTML = "Fetching location...";

                navigator.geolocation.getCurrentPosition(

                    async function (position) {

                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                        document.getElementById('accuracy').value = accuracy;

                        try {

                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
                            );

                            const data = await response.json();

                            if (data.display_name) {
                                document.getElementById('location').value =
                                    data.display_name;
                            }

                        } catch (error) {
                            console.error(error);
                        }

                        status.innerHTML =
                            `✓ Location captured (Accuracy: ${Math.round(accuracy)} meters)`;
                    },

                    function (error) {
                        status.innerHTML = "Unable to fetch location.";
                        console.error(error);
                    },

                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );
            });
    </script>

@endsection