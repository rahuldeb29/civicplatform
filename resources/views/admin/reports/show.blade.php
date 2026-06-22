@extends('layouts.admin')
@section('title', $report->title)

@push('styles')
    <style>

        body{
            margin-left: 360px;
        }
        /* ─── Page Shell ─────────────────────────────────────────── */
        .req-page {
            max-width: 1180px;
        }

        /* ─── Breadcrumb ─────────────────────────────────────────── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #9CA3AF;
            margin-bottom: 14px;
        }

        .breadcrumb a {
            color: #9CA3AF;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #374151;
        }

        .breadcrumb .sep {
            color: #D1D5DB;
        }

        .breadcrumb .current {
            color: #374151;
            font-weight: 500;
        }

        /* ─── Page Header ────────────────────────────────────────── */
        .req-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 16px;
        }

        .req-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .req-title-row h1 {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
        }

        .status-tag {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .status-resolved {
            background: #DCFCE7;
            color: #15803D;
        }

        .status-in_progress {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .status-assigned {
            background: #FEF3C7;
            color: #B45309;
        }

        .status-submitted {
            background: #F3F4F6;
            color: #6B7280;
        }

        .req-subtext {
            font-size: 13px;
            color: #6B7280;
            margin-top: 5px;
        }

        .req-subtext .dot {
            margin: 0 6px;
            color: #D1D5DB;
        }

        .req-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s;
            font-family: inherit;
        }

        .btn-outline {
            background: #fff;
            border: 1px solid #D1D5DB;
            color: #374151;
        }

        .btn-outline:hover {
            background: #F9FAFB;
        }

        .btn-dark {
            background: #111827;
            color: #fff;
        }

        .btn-dark:hover {
            background: #1F2937;
        }

        .btn svg {
            width: 14px;
            height: 14px;
        }

        /* ─── Step Tracker ───────────────────────────────────────── */
        .step-tracker {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 22px 40px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            margin-bottom: 22px;
            position: relative;
        }

        .step-tracker::before {
            content: '';
            position: absolute;
            top: 35px;
            left: calc(12.5% + 6px);
            right: calc(12.5% + 6px);
            height: 2px;
            background: #E5E7EB;
            z-index: 0;
        }

        .step-tracker-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .step-circle {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 2px solid #D1D5DB;
        }

        .step-circle svg {
            width: 13px;
            height: 13px;
            color: #9CA3AF;
        }

        .step-tracker-item.done .step-circle {
            background: #111827;
            border-color: #111827;
        }

        .step-tracker-item.done .step-circle svg {
            color: #fff;
        }

        .step-name {
            font-size: 12.5px;
            font-weight: 500;
            color: #9CA3AF;
        }

        .step-tracker-item.done .step-name {
            color: #111827;
            font-weight: 600;
        }

        /* ─── Two Column Layout ──────────────────────────────────── */
        .req-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        .req-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .req-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 20px;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14.5px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
        }

        .card-title svg {
            width: 17px;
            height: 17px;
            color: #374151;
        }

        /* ─── Evidence Photos ────────────────────────────────────── */
        .primary-photo {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
            background: #111;
            aspect-ratio: 16 / 9.5;
        }

        .primary-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .photo-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 14px;
            background: linear-gradient(transparent, rgba(0, 0, 0, .6));
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .photo-caption svg {
            width: 13px;
            height: 13px;
        }

        .thumb-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .thumb-item {
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 16/11;
            background: #F3F4F6;
            position: relative;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .thumb-more {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1.5px dashed #D1D5DB;
            color: #6B7280;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s;
            background: #FAFAFB;
        }

        .thumb-more:hover {
            background: #F3F4F6;
        }

        .thumb-more svg {
            width: 18px;
            height: 18px;
            color: #9CA3AF;
        }

        /* ─── Resolution Notes ───────────────────────────────────── */
        .resolution-text {
            background: #F9FAFB;
            border: 1px solid #F3F4F6;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 13.5px;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 14px;
        }

        .signoff-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: #6B7280;
        }

        .signoff-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #DBEAFE;
            color: #1D4ED8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .signoff-row b {
            color: #374151;
            font-weight: 600;
        }

        .signoff-row .sep {
            margin: 0 6px;
            color: #D1D5DB;
        }

        /* ─── Feedback Card ──────────────────────────────────────── */
        .feedback-sub {
            font-size: 12.5px;
            color: #9CA3AF;
            margin-bottom: 18px;
            margin-top: -8px;
        }

        .rating-label {
            font-size: 11px;
            font-weight: 700;
            color: #6B7280;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .star-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
        }

        .star {
            width: 22px;
            height: 22px;
            cursor: pointer;
        }

        .star.filled {
            color: #F59E0B;
        }

        .star.empty {
            color: #E5E7EB;
        }

        .rating-count {
            font-size: 12.5px;
            color: #6B7280;
            margin-left: 6px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #6B7280;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .feedback-textarea {
            width: 100%;
            min-height: 80px;
            padding: 11px 13px;
            background: #FAFAFA;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 13.5px;
            color: #374151;
            resize: vertical;
            font-family: inherit;
            outline: none;
            margin-bottom: 16px;
        }

        .feedback-textarea:focus {
            border-color: #9CA3AF;
            background: #fff;
        }

        .feedback-textarea::placeholder {
            color: #C4C9D4;
        }

        .btn-submit-feedback {
            background: #111827;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-submit-feedback:hover {
            background: #1F2937;
        }

        /* ─── Right Panel: Request Details ──────────────────────── */
        .detail-block {
            margin-bottom: 16px;
        }

        .detail-block:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #9CA3AF;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 13.5px;
            color: #111827;
            font-weight: 500;
            line-height: 1.5;
        }

        .detail-sub {
            font-size: 12.5px;
            color: #6B7280;
            margin-top: 1px;
        }

        .detail-with-icon {
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .detail-with-icon svg {
            width: 14px;
            height: 14px;
            color: #9CA3AF;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .ref-id-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .ref-chip {
            background: #F3F4F6;
            color: #374151;
            font-size: 11.5px;
            font-weight: 500;
            padding: 3px 9px;
            border-radius: 5px;
        }

        .mini-map {
            margin-top: 4px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            height: 100px;
            background: #E0E7FF;
            position: relative;
        }

        .mini-map img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* ─── Activity Timeline ──────────────────────────────────── */
        .activity-list {
            display: flex;
            flex-direction: column;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            position: relative;
            padding-bottom: 18px;
        }

        .activity-item:last-child {
            padding-bottom: 0;
        }

        .activity-dot-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 14px;
            flex-shrink: 0;
        }

        .activity-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #111827;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .activity-dot.muted {
            background: #D1D5DB;
        }

        .activity-line {
            flex: 1;
            width: 1.5px;
            background: #E5E7EB;
            margin-top: 4px;
            min-height: 12px;
        }

        .activity-content {
            flex: 1;
            padding-top: 0;
        }

        .activity-time {
            font-size: 11.5px;
            color: #9CA3AF;
            margin-bottom: 2px;
        }

        .activity-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .activity-desc {
            font-size: 12px;
            color: #6B7280;
            margin-top: 4px;
            background: #F9FAFB;
            padding: 7px 10px;
            border-radius: 6px;
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')
    <div class="req-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="#">Citizens</a>
            <span class="sep">›</span>
            <a href="#">Service Requests</a>
            <span class="sep">›</span>
            <span class="current">REQ-2023-0891</span>
        </div>

        {{-- Page Header --}}
        <div class="req-header">
            <div>
                <div class="req-title-row">
                    <h1>{{ $report->title }}</h1>
                    <span class="status-tag status-{{ strtolower($report->status) }}">
                        {{ strtoupper($report->status) }}
                    </span>
                </div>
                <div class="req-subtext">
                    Submitted on {{ $report->created_at->format('M d, Y') }}
                    <span class="dot">•</span>
                    Category: {{ $report->category }}
                </div>
            </div>
            <div class="req-header-actions">
                <a href="#" class="btn btn-outline" onclick="window.print(); return false;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6v-8z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Print Report
                </a>
                <button type="button" class="btn btn-dark" onclick="shareRequest()">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 12v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7M16 6l-4-4-4 4M12 2v14" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Share
                </button>
            </div>
        </div>



        @php
            $steps = [
                'submitted' => 'Submitted',
                'assigned' => 'Assigned',
                'in_progress' => 'In Progress',
                'resolved' => 'Resolved'
            ];

            $currentStep = array_search(
                strtolower($report->status),
                array_keys($steps)
            );
        @endphp

        {{-- Step Tracker --}}
        <div class="step-tracker">

            @foreach($steps as $key => $label)

                @php
                    $stepIndex = array_search($key, array_keys($steps));
                    $isDone = $stepIndex <= $currentStep;
                @endphp

                <div class="step-tracker-item {{ $isDone ? 'done' : '' }}">

                    <div class="step-circle">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>

                    <span class="step-name">
                        {{ $label }}
                    </span>

                </div>

            @endforeach

        </div>

        {{-- Main Grid --}}
        <div class="req-grid">

            {{-- LEFT COLUMN --}}
            <div class="req-left">

                {{-- Evidence Photos --}}
                <div class="card" style="padding:14px;">
                    <div class="primary-photo">
                        <img src="{{ asset('storage/' . $report->image) }}" alt="{{ $report->title }}">
                        <div class="photo-caption">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor" />
                                <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Primary Evidence
                        </div>
                    </div>

                    <div class="thumb-row">
                        <div class="thumb-item">
                            <img src="{{ asset('storage/' . $report->image) }}" alt="{{ $report->title }}">
                        </div>
                        <a href="#" class="thumb-more">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor" />
                                <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            View 3 more photos
                        </a>
                    </div>
                </div>

                {{-- Resolution Notes --}}
                <div class="card">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M9 11l3 3L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Resolution Notes
                    </div>
                    <div class="resolution-text">
                        The Department of Public Works (DPW) dispatched a repair crew on October 14th. The affected area
                        (approx. 4ft x 3ft) was excavated to remove loose base material. A new sub-base was laid and
                        compacted, followed by hot mix asphalt patching. The surface has been leveled and sealed. The
                        roadway is now safe for normal traffic flow. Temporary barricades have been removed.
                    </div>
                    <div class="signoff-row">
                        <div class="signoff-avatar">MJ</div>
                        Signed off by: <b>Michael Jenkins</b>, DPW Supervisor
                        <span class="sep">•</span>
                        Oct 14, 2023 · 14:30 IST
                    </div>
                </div>

                {{-- Feedback Card --}}
                <div class="card">
                    <div class="card-title">How did we do?</div>
                    <p class="feedback-sub">Your feedback helps us improve city services. Please rate the resolution of your
                        request.</p>

                    <form action="#" method="POST" id="feedback-form" onsubmit="return false;">
                        @csrf
                        <div class="rating-label">Service Rating</div>
                        <div class="star-row" id="star-rating">
                            <svg class="star filled" data-value="1" viewBox="0 0 24 24" fill="currentColor"
                                onclick="setRating(1)">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <svg class="star filled" data-value="2" viewBox="0 0 24 24" fill="currentColor"
                                onclick="setRating(2)">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <svg class="star filled" data-value="3" viewBox="0 0 24 24" fill="currentColor"
                                onclick="setRating(3)">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <svg class="star filled" data-value="4" viewBox="0 0 24 24" fill="currentColor"
                                onclick="setRating(4)">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <svg class="star empty" data-value="5" viewBox="0 0 24 24" fill="currentColor"
                                onclick="setRating(5)">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <span class="rating-count">4 out of 5</span>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="4">

                        <label class="form-label" for="feedback-comments">Additional Comments (Optional)</label>
                        <textarea name="comments" id="feedback-comments" class="feedback-textarea"
                            placeholder="Tell us more about your experience..."></textarea>

                        <button type="submit" class="btn-submit-feedback">Submit Feedback</button>
                    </form>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="req-right">

                {{-- Request Details --}}
                <div class="card">
                    <div class="card-title" style="margin-bottom:18px;">Request Details</div>

                    <div class="detail-block">
                        <div class="detail-label">Location</div>
                        <div class="detail-with-icon">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z" stroke="currentColor"
                                    stroke-width="2" />
                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <div>
                                <div class="detail-value">{{ $report->location }}</div>
                                <div class="detail-sub">Near intersection with Elm Ave.</div>
                            </div>

                        </div>
                        <div class="summary-item ">
                            <div class="detail-sub text-muted ">Latitude</div>
                            <div class="summary-value text-success">{{ $report->latitude }}</div>
                        </div>

                        <div class="summary-item">
                            <div class="detail-sub text-muted">Longitude</div>
                            <div class="summary-value text-success">{{ $report->longitude }}</div>
                        </div>
                    </div>

                    <div class="detail-block">
                        <div class="detail-label">Assigned Department</div>
                        @php
                            $departments = [
                                'Road Damage' => 'Public Works Department (PWD)',
                                'Street Light' => 'Electricity Department',
                                'Water Leakage' => 'Water Supply Department',
                                'Garbage' => 'Sanitation Department',
                                'Drainage' => 'Drainage Department',
                                'Electricity' => 'Electricity Department',
                            ];
                        @endphp

                        <div class="detail-value">
                            {{ $departments[$report->category] ?? 'General Department' }}
                        </div>
                    </div>

                    <div class="detail-block">
                        <div class="detail-label">Reporter</div>
                        <div class="detail-value">
                            {{ $report->user->name }}
                            <span class="detail-sub">(Citizen)</span>
                        </div>
                    </div>

                    <div class="detail-block">
                        <div class="detail-label">Reference IDs</div>
                        <div class="ref-id-row">
                            <span class="ref-chip">GIS Loc: 9982</span>
                            <span class="ref-chip">WorkOrder: 442</span>
                        </div>
                    </div>

                    <div class="detail-block">
                        <div class="card mt-4">
                            <h3 class="card-title">Location</h3>

                            <a href="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}"
                                target="_blank">

                                <iframe width="100%" height="250"
                                    style="border:none;border-radius:12px;pointer-events:none;"
                                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $report->longitude - 0.002 }},{{ $report->latitude - 0.002 }},{{ $report->longitude + 0.002 }},{{ $report->latitude + 0.002 }}&layer=mapnik&marker={{ $report->latitude }},{{ $report->longitude }}">
                                </iframe>

                            </a>

                            <div style="margin-top:10px;color:#6B7280;">
                                📍 {{ $report->latitude }}, {{ $report->longitude }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Activity Timeline --}}
                <div class="card">
                    <div class="card-title">Activity Timeline</div>
                    <div class="activity-list">

                        <div class="activity-item">
                            <div class="activity-dot-wrap">
                                <div class="activity-dot"></div>
                                <div class="activity-line"></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-time">Oct 14, 2023 · 2:30 PM</div>
                                <div class="activity-title">Status changed to Resolved</div>
                                <div class="activity-desc">Work order completed and inspected by MJ.</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot-wrap">
                                <div class="activity-dot"></div>
                                <div class="activity-line"></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-time">Oct 13, 2023 · 9:15 AM</div>
                                <div class="activity-title">Note added by Dispatch</div>
                                <div class="activity-desc">Crew scheduled for tomorrow morning. Temporary cones placed
                                    overnight.</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot-wrap">
                                <div class="activity-dot"></div>
                                <div class="activity-line"></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-time">Oct 12, 2023 · 4:45 PM</div>
                                <div class="activity-title">Status changed to In Progress</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot-wrap">
                                <div class="activity-dot"></div>
                                <div class="activity-line"></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-time">Oct 12, 2023 · 2:10 PM</div>
                                <div class="activity-title">Assigned to Dept. of Public Works</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot-wrap">
                                <div class="activity-dot muted"></div>
                            </div>
                            <div class="activity-content">
                                <div class="activity-time">Oct 12, 2023 · 1:35 PM</div>
                                <div class="activity-title">Request Submitted via Mobile App</div>
                                <div class="activity-desc">Initial assessment: High severity, causing traffic slow down.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setRating(value) {
            document.getElementById('rating-input').value = value;
            document.querySelectorAll('#star-rating .star').forEach(star => {
                const starVal = parseInt(star.dataset.value, 10);
                star.classList.toggle('filled', starVal <= value);
                star.classList.toggle('empty', starVal > value);
            });
            document.querySelector('.rating-count').textContent = value + ' out of 5';
        }

        function shareRequest() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({ title: document.title, url: url });
            } else {
                navigator.clipboard.writeText(url);
                alert('Link copied to clipboard');
            }
        }
    </script>
@endpush